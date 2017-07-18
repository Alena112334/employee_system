<div class="row align-items-center justify-content-center workers-block">
    <div class="col-sm-9">
        <div class="row justify-content-center">
            <div class="col-auto"><h3>Сотрудники</h3></div>
        </div>
        <div class="filter-block">
            <div class="row">
                <div class="col-4">
                    <label class="control-label" for="dateInput">Месяц:</label>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-md-4">
                    <input type="text" id="datepicker"/>
                </div>
                <div class="col-md-2">
                    <button id="apply-filter" type="button" class="btn btn-primary">Применить</button>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-md-4">
                    <button id="createbtn" type="button" class="btn btn-primary">Добавить сотрудника</button>
                </div>
                <div class="col-md-4">
                    <button id="prizebtn" type="button" class="btn btn-primary">Выдать премию</button>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-md-1">
                    <input type="checkbox" id="dollars">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Показать в долларах</label>
                    <div id='usrutd' hidden="true"></div>
                    <a href="http://www.forexpf.ru/"></a>
                    <script src='http://informers.forexpf.ru/php/cbrf.php?id=0'></script>
                </div>
            </div>

        </div>
        <div id="workers-block">
            <?php
            if (empty($data)) {
                echo "<div class='row justify-content-center'><div class='col-auto'>Результаты по заданному месяцу не найдены.</div></div>";
            } else {
                echo "<table class='table' id='workers'>" .
                    "<thead>" .
                    "<tr>" .
                    "<th>№</th>" .
                    "<th>Фото</th>" .
                    "<th>Фамилия</th>" .
                    "<th>Имя</th>" .
                    "<th>Должность</th>" .
                    "<th>Зарплата</th>" .
                    "</tr>" .
                    "</thead>" .
                    "<tbody>";

                $rowNum = 0;
                $len = count($data);
                $rowNum = 0;
                foreach($data as $row) {
                    $rowNum++;
                    $pos = strrpos($row['photo'], '.');
                    $photo = $row['photo'] ? (substr($row['photo'],0,$pos)."_min.".(substr($row['photo'], $pos+1))) : "/photo/w/no_photo_min.jpg";
                    echo "<tr>".
                        "<th scope='row'>".$rowNum."</th>".
                        "<td data-id='photo'><a href='".$row['photo']."' data-fancybox data-caption='".$row['first_name']." ".$row['last_name']."'>".
                        "<img class='photo-min' src='".$photo."' alt='" . $rowNum . "'/>" .
                        "</a></td>" .
                        "<td data-id='firstName'>" . $row['first_name'] . "</td>" .
                        "<td data-id='lastName'>" . $row['last_name'] . "</td>" .
                        "<td data-id='prof'>" . $row['profession'] . "</td>" .
                        "<td data-id='pay' data-cur='" .(floor($row['pay'])) . "'>" .(floor($row['pay'])) . "</td>" .
                        "</tr>";
                }
            }
            ?>
        </div>
        </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        initDate($("#datepicker"));
        $("#apply-filter").click(function () {
            getWorkers($("#datepicker").val());
        });
        $("#createbtn").click(function () {
            $(location).attr('href', "/worker/new");
        });
        $("#prizebtn").click(function () {
            $(location).attr('href', "/worker/prize");
        });
        $('#dollars').on('change', function (e) {
            if (this.checked) {
                transfer(true);
            } else {
                transfer(false);
            }
        });
    });
</script>