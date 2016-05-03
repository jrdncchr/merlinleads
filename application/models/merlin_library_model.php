<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class merlin_library_model extends CI_Model {

    private $merlin_library_table = 'merlin_library';
    private $merlin_templates_table = 'merlin_templates';
    private $merlin_snippets_table = 'merlin_snippets';
    private $merlin_category_table = 'merlin_library_category';
    private $merlin_library_post_table = 'merlin_library_posts';
    private $scheduler_post_table = 'scheduler_posts';

    function __construct() {
        $this->load->database();
    }

    /*
     * Merlin Library
     */
    public function library_get($library_id = 0) {
        if($library_id == 0) {
            $this->db->reconnect();
            $query = $this->db->query("call getMerlinLibraries()");
            $result = $query->num_rows() > 0 ? $query->result() : array();
        } else {
            $query = $this->db->get_where($this->merlin_library_table, array('id' => $library_id));
            $result = $query->row();
        }
        return $result;
    }

    public function library_save($library) {
        $result = array('success' => false);
        if(isset($library['id'])) {
            $this->db->where('id', $library['id']);
            unset($library['id']);
            if($this->db->update($this->merlin_library_table, $library)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->merlin_library_table, $library)) {
                $result['success'] = true;
                $result['id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function library_delete($library_id) {
        $result = array('success' => false, 'message' => 'Something went wrong!');

        $this->db->trans_begin();
        $this->db->where('id', $library_id);
        if($this->db->delete($this->merlin_library_table)) {
            $this->db->where('library_id', $library_id);
            $this->db->delete($this->merlin_templates_table);
        }

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result['success'] = true;
            unset($result['message']);
        }
        $this->db->trans_complete();
        return $result;
    }

    public function library_get_template($scheduler) {
        $this->db->reconnect();

        $this->db->order_by('date_created', 'asc');
        $result = $this->db->get_where($this->merlin_templates_table, array('category_id' => $scheduler->category_id));
        $templates = $result->result();

        $this->db->order_by('date_posted', 'desc');
        $result = $this->db->get_where($this->scheduler_post_table, array('scheduler_id' => $scheduler->scheduler_id));
        if($result->num_rows() > 0) {
            $posts = $result->result();
            if($posts[0]->template_id == $templates[sizeof($templates)-1]->id) {
                return $templates[0];
            } else {
                for($i = 0; $i < sizeof($templates); $i++) {
                    if($posts[0]->template_id == $templates[$i]->id) {
                        return $templates[$i+1];
                    }
                }
            }
        }
        return $templates[0];
    }

    /*
     * Templates
     */
    public function templates_get($library_id, $template_id = 0) {
        if($template_id == 0) {
            $this->db->select('*');
            $this->db->from($this->merlin_templates_table);
            $this->db->join($this->merlin_category_table, 'merlin_library_category.category_id = merlin_templates.category_id', 'left');
            $query = $this->db->get();
            $result = $query->result();
        } else {
            $this->db->join($this->merlin_category_table, 'merlin_library_category.category_id = merlin_templates.category_id', 'left');
            $query = $this->db->get_where($this->merlin_templates_table, array('merlin_templates.library_id' => $library_id, 'merlin_templates.id' => $template_id));
            $result = $query->row();
        }
        return $result;
    }

    public function templates_get_where($where) {
        $result = $this->db->get_where($this->merlin_templates_table, $where);
        return $result->result();
    }

    public function templates_save($template) {
        $result = array('success' => false);
        if(isset($template['id'])) {
            $this->db->where('id', $template['id']);
            unset($template['id']);
            if($this->db->update($this->merlin_templates_table, $template)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->merlin_templates_table, $template)) {
                $result['success'] = true;
                $result['id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function templates_delete($ids) {
        $result = array("success" => false);
        $this->db->trans_begin();
        foreach($ids as $id) {
            $this->db->where('id', $id);
            $this->db->delete($this->merlin_templates_table);
        }

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result['success'] = true;
            unset($result['message']);
        }
        $this->db->trans_complete();
        return $result;
    }

    /*
     * Categories
     */
    public function category_get($library_id, $category_id = 0) {
        if($category_id > 0) {
            $query = $this->db->get_where($this->merlin_category_table, array('library_id' => $library_id, 'category_id' => $category_id));
            $result = $query->row();
        } else {
            $query = $this->db->get_where($this->merlin_category_table, array('library_id' => $library_id));
            $result = $query->result();
        }
        return $result;
    }

    public function category_get_where($where) {
        $query = $this->db->get_where($this->merlin_category_table, $where);
        $result = $query->result();
        return $result;
    }

    public function category_get_for_option($library_id) {
        $query = $this->db->get_where($this->merlin_category_table, array('library_id' => $library_id));
        $categories = $query->result();
        $html = "";
        foreach($categories as $c) {
            $html .= "<option value='" . $c->category_id . "'>" . $c->category_name . "</option>";
        }
        return $html;
    }

    public function category_get_next_template($category_id, $user_id) {
        $this->db->order_by('date_created', 'asc');
        $templates = $this->templates_get_where(array('category_id' => $category_id));
        $last_template = $templates[sizeof($templates)-1];

        $this->db->order_by('date_created', 'desc');
        $last_post = $this->post_get_last($category_id, $user_id);
        if(sizeof($last_post) > 0) {
            if($last_post->template_id != $last_template->id) {
                for($i = 0; $i < sizeof($templates); $i++) {
                    if($templates[$i]->template_id == $last_post->template_id) {
                        return $templates[$i + 1];
                    }
                }
            }
        }

        return $templates[0];
    }

    public function category_save($category) {
        $result = array('success' => false);
        if(isset($category['category_id'])) {
            $this->db->where('category_id', $category['category_id']);
            if($this->db->update($this->merlin_category_table, $category)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->merlin_category_table, $category)) {
                $result['success'] = true;
                $result['category_id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function category_delete($ids) {
        $result = array("success" => false);
        $this->db->trans_begin();
        foreach($ids as $id) {
            $this->db->where('category_id', $id);
            $this->db->delete($this->merlin_category_table);

            $this->db->where('category_id', $id);
            $this->db->delete($this->merlin_templates_table);
        }

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result['success'] = true;
            unset($result['message']);
        }
        $this->db->trans_complete();
        return $result;
    }

    /*
     * Snippets
     */
    public function snippet_get($library_id, $snippet_id = 0) {
        if($snippet_id == 0) {
            $this->db->select('*');
            $this->db->from($this->merlin_snippets_table);
            $this->db->join($this->merlin_category_table, 'merlin_library_category.category_id = merlin_snippets.category_id', 'left');
            $this->db->where('merlin_snippets.library_id', $library_id);
            $query = $this->db->get();
            $result = $query->result();
        } else {
            $this->db->join($this->merlin_category_table, 'merlin_library_category.category_id = merlin_snippets.category_id', 'left');
            $query = $this->db->get_where($this->merlin_snippets_table, array('merlin_templates.library_id' => $library_id, 'merlin_snippets.snippet_id' => $snippet_id));
            $result = $query->row();
        }
        return $result;
    }

    public function snippet_save($snippet) {
        $result = array('success' => false);
        if(isset($snippet['snippet_id'])) {
            $this->db->where('snippet_id', $snippet['snippet_id']);
            if($this->db->update($this->merlin_snippets_table, $snippet)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->merlin_snippets_table, $snippet)) {
                $result['success'] = true;
                $result['id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function snippet_delete($ids) {
        $result = array("success" => false);
        $this->db->trans_begin();
        foreach($ids as $id) {
            $this->db->where('snippet_id', $id);
            $this->db->delete($this->merlin_snippets_table);
        }

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result['success'] = true;
            unset($result['message']);
        }
        $this->db->trans_complete();
        return $result;
    }

    /*
     * MERLIN LIBRARY POST
     */

    public function post_get_where($where) {
        $list = $this->db->get_where($this->merlin_library_post_table, $where);
        return $list->result();
    }

    public function post_get_last($category_id, $user_id) {
        $query = $this->db->get_where($this->merlin_library_post_table, array('category_id' => $category_id, 'user_id' => $user_id));
        return $query->row();
    }

} 