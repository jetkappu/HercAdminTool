<?php
Class Charmodel extends CI_Model {
	
	function list_online() {
		$this->db_ragnarok->select('char.char_id,char.account_id,char.char_num,char.name,char.class,char.base_level,char.job_level,char.zeny,char.last_map,char.last_x,char.last_y,char.job_level,char.guild_id AS char_guid,char.online,guild.guild_id,guild.name AS guild_name');
		$this->db_ragnarok->from('char')->order_by('char.char_id','asc');
		$this->db_ragnarok->where('char.online', '1');
		$this->db_ragnarok->join('guild', 'char.guild_id = guild.guild_id', 'left');
		$query = $this->db_ragnarok->get();
		return $query->result_array();
	}
	
	function get_char_info($cid) {
		$this->db_ragnarok->select('char.*,guild.guild_id,guild.name AS guild_name,party.party_id,party.name AS party_name');
		$this->db_ragnarok->from('char');
		$this->db_ragnarok->where('char.char_id', $cid);
		$this->db_ragnarok->join('guild', 'char.guild_id = guild.guild_id', 'left');
		$this->db_ragnarok->join('party', 'char.party_id = party.party_id', 'left');
		$query = $this->db_ragnarok->get();
		return $query->row();
	}
	
	function get_char_items($cid) {
		$this->db_ragnarok->select('inventory.*,item_db.id,item_db.name_japanese,item_db.type');
		$this->db_ragnarok->from('inventory')->order_by('inventory.equip', 'asc')->order_by('item_db.id', 'asc');
		$this->db_ragnarok->where('inventory.char_id', $cid);
		$this->db_ragnarok->join('item_db', 'inventory.nameid = item_db.id', 'left');
		$q = $this->db_ragnarok->get();
		return $q->result_array();
	}
	
	function get_cart_items($cid) {
		$this->db_ragnarok->select('cart_inventory.*,item_db.id,item_db.name_japanese,item_db.type');
		$this->db_ragnarok->from('cart_inventory')->order_by('item_db.id', 'asc');
		$this->db_ragnarok->where('cart_inventory.char_id', $cid);
		$this->db_ragnarok->join('item_db', 'cart_inventory.nameid = item_db.id', 'left');
		$q = $this->db_ragnarok->get();
		return $q->result_array();
	}
}