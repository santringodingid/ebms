<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthModel extends CI_Model
{
    public function login()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $cekUser = $this->db->get_where('users', ['username' => $username])->row_object();
        if ($cekUser) {
            $passwordDB = $cekUser->password;
            if (password_verify($password, $passwordDB) == FALSE) {
                return [
                    'status' => 500,
                    'message' => 'Kombinasi username dan password tidak valid'
                ];
            } else {
                $status = $cekUser->status;
                if ($status == 'INACTIVE') {
                    return [
                        'status' => 500,
                        'message' => 'Pengguna ini sudah dinon-aktifkan'
                    ];
                } else {
                    $role = $cekUser->role;
                    if ($role == 'SUPER-ADMIN') {
                        $textRole = 'SUPER ADMIN';
                    } elseif ($role == 'ADMIN') {
                        $textRole = 'ADMIN';
                    } elseif ($role == 'DEV') {
                        $textRole = 'DEVELOPER';
                    } elseif ($role == 'ADMIN-SECURITY') {
                        $textRole = 'ADMIN KAMTIB';
                    } elseif ($role == 'SECURITY') {
                        $textRole = 'STAF KAMTIB';
                    } else {
                        $textRole = str_replace('-', ' ', $role);
                    }

                    $data = [
                        'user_id' => $cekUser->id,
                        'username' => $cekUser->username,
                        'role' => $role,
                        'name' => $cekUser->name,
                        'text_role' => $textRole
                    ];
                    $this->session->set_userdata($data);
                    return [
                        'status' => 200,
                        'message' => 'Login sukses'
                    ];
                }
            }
        } else {
            return [
                'status' => 500,
                'message' => 'Kombinasi username dan password tidak valid'
            ];
        }
    }
}
