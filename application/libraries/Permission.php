<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
*    Permission Class
*    COPYRIGHT (C) 2008-2009 Haloweb Ltd
*    http://www.haloweb.co.uk/blog/
*
*    Version:    0.9.1
*    Wiki:       http://codeigniter.com/wiki/Permission_Class/
*
*    Description:
*    The Permission class uses keys in a session to allow or disallow functions
*    or areas of a site. The keys are stored in a database and this class adds 
*    and/or takes them away. The use of IF statements are required within
*    controllers and views, please see wiki for code.
*
*    Permission is hereby granted, free of charge, to any person obtaining a copy
*    of this software and associated documentation files (the "Software"), to deal
*    in the Software without restriction, including without limitation the rights
*    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
*    copies of the Software, and to permit persons to whom the Software is
*    furnished to do so, subject to the following conditions:
* 
*    The above copyright notice and this permission notice shall be included in
*    all copies or substantial portions of the Software.
* 
*    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
*    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
*    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
*    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
*    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
*    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
*    THE SOFTWARE.
**/

class Permission {

    // init vars
    var $CI;                        // CI instance
    var $where = array();
    var $set = array();
    var $required = array();

    function Permission()
    {
        // init vars
        $this->CI =& get_instance();

        // set groupID from session (if set)
        $this->groupID = ($this->CI->session->userdata('group')) ? $this->CI->session->userdata('group') : 0;
    }

    // get permissions from for this group
    function get_user_permissions($groupID)
    {
        // grab keys
        // $this->CI->db->select('access','module');

        // get groups
        $this->CI->db->where('position_id', $groupID);

        $query =  $this->CI->db->get('atombizz_employee_access', $groupID);

        // set permissions array and return
        if ($query->num_rows())
        {
            foreach ($query->result_array() as $row)
            {
                
                $permissions['access'] = json_decode($row['access']);
                $permissions['module'] = json_decode($row['module']);

            }
            return $permissions;
        }
        else
        {
            return false;
        }
    }

    function check_module_permission($access){
        // $CI =& get_instance();
        // $CI->load->library('permission');
        $groupID = $this->CI->session->userdata('astrosession');
        
        $permission = $this->get_user_permissions($groupID[0]->group);
        // print_r($permission);exit;
        if(!in_array($access, $permission['module'])){
            show_error($message = "SORRY! You don't have permission to access this page.", 500, $heading = 'Permission Denied');
            EXIT;
        }
    }

    function check_permission($access){
        // $CI =& get_instance();
        // $CI->load->library('permission');
        $groupID = $this->CI->session->userdata('astrosession');
        $permission = $this->get_user_permissions($groupID[0]->group);
        if(!in_array($access, $permission['access'])){
            show_error($message = "SORRY! You don't have permission to access this page.", 500, $heading = 'Permission Denied');
            EXIT;
        }
    }

    function check_permission_value($access){
        // $CI =& get_instance();
        // $CI->load->library('permission');
        $groupID = $this->CI->session->userdata('astrosession');
        $permission = $this->get_user_permissions($groupID[0]->group);
        if(!in_array($access, $permission['access'])){
           return FALSE; 
        } else {
            return TRUE;
        }
    }
}