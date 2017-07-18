<?php

const MAX_SIZE = 200000;
const DIRECTORY_IMG = 'photo/w/';
const WITH_MIN_IMG = 60;

const INSERT_WORKER_SQL = "INSERT INTO workers (first_name, last_name, profession_id, salary, photo) VALUES(?, ?, ?, ?, ?)";
const SELECT_WORKERS_BY_DATE_SQL = "SELECT w.photo, w.first_name, w.last_name, prof.name profession, p.pay " .
    "FROM workers w " .
    "LEFT JOIN professions prof ON prof.id = w.profession_id " .
    "LEFT JOIN payment p ON p.worker_id = w.id " .
    "WHERE p.date = ? OR p.pay IS NULL ORDER BY w.first_name";
const SELECT_WORKER_BY_PROF_SQL = "SELECT id FROM workers WHERE profession_id = ?";
const SELECT_PROFESSIONS_SQL = "SELECT id, name FROM professions";

class Model_Worker extends Model
{
    public function create($values)
    {
        if ($values['first_name'] == "" || $values['last_name'] == "" || $values['profession'] == "" || $values['salary'] == "") {
            die(json_encode(array('err' => 'Пожалуйста, заполните все требуемые поля.')));
        }
        $photo = "";
        if (!empty($values['photo']) && $values['photo']['error'] == 0) {
            $photo = $this->loadPhoto($values['photo']);
        }

        if ($this->insertWorker($values['first_name'], $values['last_name'], $values['profession'], $values['salary'], "/".$photo)) {
            return true;
        } else {
            die(json_encode(array('err' => 'Не удалось создать сотрудника.')));
        }

    }

    public function get_data($values)
    {
        $date = [];
        if (empty($values['date'])) {
            $date['month'] = date('m');
            $date['year'] = date('Y');
        } else {
            $date = date_parse($values['date']);
            if (!$date['month'] || !$date['year']) {
                die(json_encode(array('err' => 'Некорректная дата')));
            }
        }
        $month = strval($date['month']);
        $dateStr = $date['year'] . "-" . (strlen($month) == 1 ? "0" . $month : $month) . "-10";

        global $conn;
        $statement = $conn->prepare(SELECT_WORKERS_BY_DATE_SQL);

        $statement->execute([$dateStr]);
        $results = $statement->fetchAll();
        return $results;
    }

    public function getprof()
    {
        global $conn;

        return $conn->query(SELECT_PROFESSIONS_SQL);
    }

    public function setprize_data($values)
    {
        $insertOrUpdateSql = "INSERT INTO payment (worker_id, date, pay) VALUES ";
        $date = date_parse($values['date']);
        if (empty($date['month']) || empty($date['year'])) {
            die(json_encode(array('err' => 'Некорректная дата ')));
        }

        $month = strval($date['month']);
        $dateStr = $date['year'] . "-" . (strlen($month) == 1 ? "0" . $month : $month) . "-10";

        $ids = $this -> get_worker_ids_by_prof($values['prof_id']);
        $count = count($ids);

        for ($i = 0; $i < $count; $i++) {
            $insertOrUpdateSql = $insertOrUpdateSql . "( ?, ?, ?)";
            if ($i != ($count - 1)) $insertOrUpdateSql = $insertOrUpdateSql . ", "; //если не последнее значение в запросе, ставим запятую
        }
        $insertOrUpdateSql = $insertOrUpdateSql . " ON DUPLICATE KEY UPDATE pay = pay + VALUES(pay)";

        global $conn;
        $stm2 = $conn->prepare($insertOrUpdateSql);
        $valuesArr = [];
        foreach ($ids as $id) {
            $valuesArr[] = (int)($id['id']);
            $valuesArr[] = $dateStr;
            $valuesArr[] = $values['pay'];
        }
        $result = $stm2->execute($valuesArr);
        if ($result == 0) {
            die(json_encode(array('err' => 'Изменения не были внесены.')));
        } else {
            return true;
        }
    }

    private function insertWorker($firstName, $lastName, $profession, $salary, $photo)
    {
        global $conn;

        $statement = $conn->prepare(INSERT_WORKER_SQL);
        $result = $statement->execute([$firstName, $lastName, $profession, $salary, $photo]);
        if ($result == 0) return false;
        return true;
    }


    private function loadPhoto($image)
    {

        if ($image['size'] > MAX_SIZE) {
            die(json_encode(array('err' => 'Размер фото превышает ' . (MAX_SIZE / 1000) . 'Кб.')));
        }

        $imageFormat = explode('.', $image['name']);
        $imageFormat = $imageFormat[1];
        $imageType = $image['type'];

        if (!($imageType == 'image/jpeg' || $imageType == 'image/png' || $imageType == 'image/jpg')) {
            die(json_encode(array('err' => 'Недопустимый формат изображения. Требуемый формат: jpeg, jpg, png')));
        }
        $imageName = hash('crc32', time());
        $imageFullName = DIRECTORY_IMG . $imageName . '.' . $imageFormat;
        if (!file_exists(DIRECTORY_IMG)) {
            if (!mkdir(DIRECTORY_IMG)) {
                die(json_encode(array('err' => 'Возникли проблемы! попробуйте снова!')));
            }
        }

        if (move_uploaded_file($image['tmp_name'], $imageFullName)) {
            $this->createThumbnail($imageName, $imageFormat, DIRECTORY_IMG, WITH_MIN_IMG);
            return $imageFullName;
        } else {
            die(json_encode(array('err' => 'Не удалось загрузить фото.')));
        }
    }

    private function createThumbnail($imageName, $imageFormat, $pathDirectoryImg, $widthOfMinImg)
    {
        $fullNameSource = $pathDirectoryImg . $imageName . "." . $imageFormat;
        $fullNameTarget = $pathDirectoryImg . $imageName . "_min." . $imageFormat;

        switch ($imageFormat) {
            case 'gif':
                $im = imagecreatefromgif($fullNameSource);
                break;
            case 'jpeg':
            case 'jpg':
                $im = imagecreatefromjpeg($fullNameSource);
                break;
            case 'png':
                $im = imagecreatefrompng($fullNameSource);
                break;
        }

        $ox = intval(imagesx($im));
        $oy = intval(imagesy($im));

        $nx = $widthOfMinImg;
        $ny = floor($oy * ($widthOfMinImg / $ox));

        $nm = imagecreatetruecolor($nx, $ny);
        imagecopyresized($nm, $im, 0, 0, 0, 0, $nx, $ny, $ox, $oy);
        imagejpeg($nm, $fullNameTarget, 90);
        imagedestroy($nm);
        return true;
    }

    private function get_worker_ids_by_prof($prof_id)
    {
        global $conn;

        $stm1 = $conn->prepare(SELECT_WORKER_BY_PROF_SQL);
        $stm1->execute([$prof_id]);
        return $stm1->fetchAll();
    }

}