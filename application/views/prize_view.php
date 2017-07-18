<div class="row align-items-center justify-content-center workers-block">
    <div class="col-sm-5">
        <div class="row justify-content-center">
            <div class="col-auto"><h3>Выдать премию</h3></div>
        </div>
        <form class="creation-block" enctype="multipart/form-data" method="POST" id="prizeForm"
              name="prizeForm">

            <div class="form-group required">
                <label class="control-label" for="datepicker">Месяц:</label>
                <input class="form-control" type="text" id="datepicker" name="datepicker"/>
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
                <label class="control-label" for="prizeInput">Премия</label>
                <input class="form-control" type="number" value="0" id="prizeInput" name="prizeInput" min="0">
            </div>
            <button type="submit" class="btn btn-primary" id="savebtn">Сохранить</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        initDate($("#datepicker"));
        $('#prizeForm').on('submit', function (e) {
            var form = document.getElementById('prizeForm');
            var formData = new FormData(form);
            setPrize(formData);
            e.preventDefault();
        });
    });
</script>