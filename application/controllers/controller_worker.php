<?php


class Controller_Worker extends Controller
{
    function __construct()
    {
        $this->model = new Model_Worker();
        $this->view = new View();
    }

    /**
     * Returns workers
     */
    function action_get()
    {
        $values['date'] = $_POST['date'];
        $data = $this->model->get_data($values);
        if(empty($_POST['is_reload']) || $_POST['is_reload'] == 'true'){
            $this->view->generate('worker_view.php', 'template_view.php', $data);
        } else {
            die(json_encode(array('res' => $data)));
        }
    }

    /**
     * Generated page for worker created
     */

    function action_new()
    {
        $data = $this->model->getprof();
        $this->view->generate('newworker_view.php', 'template_view.php', $data);
    }

    /**
     * Created new worker
     */
    function action_set()
    {
        $values = [];
        $values['first_name']  = $_POST['firstNameInput'];
        $values['last_name']   = $_POST['lastNameInput'];
        $values['profession']  = $_POST['profInput'];
        $values['salary']      = $_POST['salaryInput'];
        $values['photo']      = isset($_FILES) ? $_FILES['photo'] : null;

        $this->model->create($values);
        $this->view->generate('worker_view.php', 'template_view.php');

    }

    /**
     * Generated page for set prize to workers by profession
     */
    function action_prize()
    {
        $data = $this->model->getprof();
        $this->view->generate('prize_view.php', 'template_view.php', $data);
    }

    /**
     * Set prize to workers by profession
     */
    function action_setprize()
    {
        $values = [];
        $values['pay']     = $_POST['prizeInput'];
        $values['prof_id'] = $_POST['profInput'];
        $values['date']    = $_POST['datepicker'];

        $this->model->setprize_data($values);
        $this->view->generate('worker_view.php', 'template_view.php');
    }


}