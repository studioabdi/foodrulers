<?php
class Challenge_model extends CI_Model {

	private $table = "food_challenge";

    public function get_challenge_info($challenge_id){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $challenge_id);
        return $this->db->get()->row_array();
    }

	public function get_challenge_list($option){
		// filter by field query
        $query = isset($option['query']) && is_array($option['query']) ? $option['query'] : null;
        if (is_array($query)) {
            foreach ($query as $key => $val) {
                if ($key != 'generalSearch') {
                    $this->db->where($key, $val);
                }
            }
        }

        $sort = !empty($option['sort']['sort']) ? $option['sort']['sort'] : 'desc';
        $field = !empty($option['sort']['field']) ? $option['sort']['field'] : 'created_at';

        $this->db->select('*');
        $this->db->from($this->table.' a');
		$this->db->where('is_delete', '0');
        $this->db->order_by($field, $sort);
		
		return $this->db->get()->result_array();
	}
}