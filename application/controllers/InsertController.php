<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InsertController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function insert()
    {
        $table_name = $this->input->post('table');

        // form validation from php
        $fields = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z ]+$/]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_emails|is_unique[' . $table_name . '.email]'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|max_length[15]'
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|exact_length[10]|numeric|is_unique[' . $table_name . '.phone]'
            ],
            [
                'field' => 'gender[]',
                'label' => 'Gender',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'languages[]',
                'label' => 'Languages',
                'rules' => 'required|trim'
            ]
        ];

        $keys = [];
        $values = [];

        // Filter out the fields that are not present in the form data
        $fields_to_validate = array_filter($fields, function ($field) {
            return $this->input->post($field['field']) !== NULL;
        });

        // validation for image
        if (empty($_FILES['image']['name'])) {
            $this->form_validation->set_rules("image", "Image", 'required');
            array_push($keys, 'image');
            array_push($values, form_error('image'));
        }
        // setting rules for form here 
        $this->form_validation->set_rules($fields_to_validate);

        // If All things in form are correct it goes here 
        if ($this->form_validation->run()) {

            // Uploading image here 
            $path = $_POST['upload-path-of-image'];

            // image configration
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            // images uploading here
            if (!$this->upload->do_upload('image')) {

                $error = $this->upload->display_errors();
                echo json_encode(['imageError' => $error, 'fields' => 'image']);
                
            } else {

                // getting form data
                $postData = $this->input->post();
                $imageData = $this->upload->data(); // getting image all data 
                $postData['image'] = $imageData['file_name']; // getting file name 
                $this->load->model('insertmodel');
                $modelData = $this->insertmodel->insert($postData);
                // echo json_encode(["formData"=>$postData , "image_path"=>$path , "success"=>true]);
                echo $modelData;
                // print_r($modelData);

            }
        }
        // throwing error on frontend 
        else {
            for ($i = 0; $i < count($fields); $i++) {
                if (!empty(form_error($fields[$i]['field']))) {
                    array_push($keys, $fields[$i]['field']);
                    array_push($values, form_error($fields[$i]['field']));
                }
            }

            echo json_encode(['errorKeys' => $keys, 'errorValues' => $values, 'fields' => 'fields']);
        }
    }
}
