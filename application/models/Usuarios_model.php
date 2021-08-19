<?php 
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Fluent\JWTAuth\Contracts\JWTSubjectInterface;

class Usuarios_model extends CI_Model implements JWTSubjectInterface
{
    const TABELA           = 'pt_usuarios';
    const COLUNA_ID        = 'usuario_id';
    const COLUNA_EMAIL = 'usuario_email';

    private $search;

    public function __construct()
    {
        parent::__construct();
    }

    public function checa_acesso_admin($email)
    {
        if (!empty($email)) {
            $this->db->where('usuario_email', $email);
            $this->db->where('usuario_status', 1);
            $query = $this->db->get('pt_usuarios', 1);

            if ($query->num_rows()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function set_search($search)
    {
        $this->search = $search;
    }

    public function get_all($limit = null, $offset = null)
    {
        if ($this->search) {
            $this->db->like(self::COLUNA_EMAIL, $this->search);
        }
        $this->db->order_by(self::COLUNA_EMAIL, 'ASC');
        $query = $this->db->get(self::TABELA, $limit, $offset);
        return $query->result();
    }

    public function get_total_rows()
    {
        if ($this->search) {
            $this->db->like(self::COLUNA_EMAIL, $this->search);
        }
        return $this->db->count_all_results(self::TABELA);
    }

    public function get_entry($id)
    {
        $this->db->where(self::COLUNA_ID, $id);
        $query = $this->db->get(self::TABELA);
        return $query->row();
    }

    public function save($data, $id = NULL) {
        $this->db->set(self::COLUNA_EMAIL, $data['usuario_email']);
        if (!$id) {
            return $this->db->insert(self::TABELA);
        } else {
            $this->db->where(self::COLUNA_ID, $id);
            return $this->db->update(self::TABELA);
        }
    }

    public function remove($id)
    {
        $this->db->where(self::COLUNA_ID, $id);
        return $query = $this->db->delete(self::TABELA);
    }

    public function remove_multiple($id)
    {
        $this->db->where_in(self::COLUNA_ID, $id);
        return $query = $this->db->delete(self::TABELA);
    }


    /**
     * {@inheritdoc}
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
