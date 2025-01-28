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

        $this->load->helper('uniqueness');

        $is_unique_email = uniqueHelper('email', $table_name , $this->input->post('email') , 'id' , $this->input->post('id') );
        $is_unique_phone = uniqueHelper('phone', $table_name , $this->input->post('phone') , 'id' , $this->input->post('id') );

        if(!empty(trim($this->input->post('password')))){
            $required_password = "|required|trim";
        }
        else{
            $required_password = "";
        }

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
                'rules' => 'required|trim|valid_emails' . $is_unique_email,
                "errors" => [
                    'is_unique' => 'The %s is already exist.',
                ],
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'min_length[8]|max_length[15]'.$required_password,
            ],
            [
                'field' => 'phone',
                'label' => 'Phone number',
                'rules' => 'required|trim|exact_length[10]|numeric'.$is_unique_phone,
                "errors" => [
                    'is_unique' => 'The %s is already exist.',
                ],
            ],
            [
                'field' => 'pincode',
                'label' => 'Pincode',
                'rules' => 'required|trim|max_length[6]|numeric',
            ],
            [
                'field' => 'state',
                'label' => 'State',
                'rules' => 'required|trim|numeric',
            ],
            [
                'field' => 'district',
                'label' => 'District',
                'rules' => 'required|trim|numeric',
            ],
            [
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required|trim',
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
        if (!isset($_FILES)){
            if (empty($_FILES['image']['name'])) {
                $this->form_validation->set_rules("image", "Image", 'required');
                array_push($keys, 'image');
                array_push($values, form_error('image'));
            }
        }

        // setting rules for form here 
        $this->form_validation->set_rules($fields_to_validate);

        // If All things in form are correct it goes here 
        if ($this->form_validation->run()) {

            // Uploading image here 
            if(isset($_POST['upload-path-of-image'])){
                $path = $_POST['upload-path-of-image'];
                // image configration
                $config['upload_path'] = $path;
            }
            
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            // images uploading here
            if (!$this->upload->do_upload('image') && !$this->input->post('action') == "update" &&  isset($_POST['upload-path-of-image'])) {
                if(!empty($_FILES['image']['name'])){
                    $error = $this->upload->display_errors();
                    echo json_encode(['imageError' => $error, 'fields' => 'image']);
                }
                echo "here i am ";
            } else {

                // getting form data
                $postData = $this->input->post();
                if(!empty($_FILES['image']['name'])){
                    $imageData = $this->upload->data(); // getting image all data 
                    $postData['image'] = $imageData['file_name']; // getting file name
                }
                $this->load->model('insertmodel');
                if($this->input->post('action') == "update"){
                    unset($postData['upload-path-of-image']);
                    unset($postData['action']);
                    if(isset($postData['password']) && empty(trim($postData['password']))){
                        unset($postData['password']);
                    }
                    $modelData = $this->insertmodel->update($postData);
                    echo $modelData;
                }
                else{
                    $modelData = $this->insertmodel->insert($postData);
                    echo $modelData;
                }

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
