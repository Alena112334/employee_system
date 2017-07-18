<div class="row align-items-center justify-content-center workers-block">
    <div class="col-sm-5">
        <div class="row justify-content-center">
            <div class="col-auto"><h3>Создание сотрудника</h3></div>
        </div>
        <form class="creation-block" enctype="multipart/form-data" method="POST" id="newWorkerForm"
              name="newWorkerForm">
            <div class="form-group required">
                <label class="control-label" for="firstNameInput">Фамилия</label>
                <input type="text" class="form-control" id="firstNameInput" name="firstNameInput"
                       placeholder="Введите фамилию">
            </div>
            <div class="form-group required">
                <label class="control-label" for="lastNameInput">Имя</label>
                <input type="text" class="form-control" id="lastNameInput" name="lastNameInput"
                       placeholder="Введите имя">
            </div>
            <div class="form-group required">
                <label class="control-label" for="profInput">Должность</label>
                <select class="form-control" id="profInput" name="profInput">
                    <?php
                    foreach ($data as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group required">
                <label class="control-label" for="salaryInput">Зарплата</label>
                <input class="form-control" type="number" value="0" id="salaryInput" name="salaryInput">
            </div>
            <div class="form-group">
                <label class="control-label" for="photoInput">Фото</label>
                <input type="file" class="form-control" name="photo" id="photo" accept="image/jpg, image/jpeg,image/png,image/gif">
            </div>
            <button type="submit" class="btn btn-primary" id="savebtn">Сохранить</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#newWorkerForm').on('submit', function (e) {
            var form = document.getElementById('newWorkerForm');
            var formData = new FormData(form);
            initCreateWorker(formData);
            e.preventDefault();
        });
    });
</script>