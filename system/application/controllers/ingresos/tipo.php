<?php
class tipo extends Controller {
	var $titp='Tipos de Vehiculos';
	var $tits='Tipo de Vehiculo';
	var $url ='ingresos/tipo/';
	function tipo(){
		parent::Controller();
		$this->load->library("rapyd");
		$this->datasis->modulo_id(322,1);
	}
	function index(){
		redirect($this->url."filteredgrid");
	}
	function filteredgrid(){
		$this->rapyd->load('datafilter','datagrid');

		$filter = new DataFilter($this->titp, 'tipo');

		$filter->tipo = new inputField('Tipo','tipo');
		$filter->tipo->rule      ='max_length[30]';
		$filter->tipo->size      =32;
		$filter->tipo->maxlength =30;

		$filter->buttons('reset', 'search');
		$filter->build();

		$uri = anchor($this->url.'dataedit/show/<raencode><#tipo#></raencode>','<#tipo#>');

		$grid = new DataGrid('');
		$grid->order_by('tipo');
		$grid->per_page = 40;

		$grid->column_orderby('Tipo',"$uri",'tipo');

		$grid->add($this->url.'dataedit/create');
		$grid->build();

		$data['filtro']  = $filter->output;
		$data['content'] = $grid->output;
		$data['head']    = $this->rapyd->get_head().script('jquery.js');
		$data['title']   = $this->titp;
		$this->load->view('view_ventanas', $data);

	}
	function dataedit(){
		$this->rapyd->load('dataedit');

		$edit = new DataEdit($this->tits, 'tipo');

		$edit->back_url = site_url($this->url."filteredgrid");

		$edit->post_process('insert','_post_insert');
		$edit->post_process('update','_post_update');
		$edit->post_process('delete','_post_delete');

		$edit->tipo = new inputField('Tipo','tipo');
		$edit->tipo->rule='max_length[30]';
		$edit->tipo->size =32;
		$edit->tipo->maxlength =30;
		$edit->tipo->mode='autohide';
		$edit->tipo->when=array('show','modify','create');

		$edit->buttons('add','modify', 'save', 'undo', 'delete', 'back');
		$edit->build();
		$data['content'] = $edit->output;
		$data['head']    = $this->rapyd->get_head();
		$data['title']   = $this->tits;
		$this->load->view('view_ventanas', $data);

	}

	function _post_insert($do){
		$primary =implode(',',$do->pk);
		logusu($do->table,"Creo $this->tits $primary ");
	}
	function _post_update($do){
		$primary =implode(',',$do->pk);
		logusu($do->table,"Modifico $this->tits $primary ");
	}
	function _post_delete($do){
		$primary =implode(',',$do->pk);
		logusu($do->table,"Elimino $this->tits $primary ");
	}

	function instalar(){
		$mSQL="CREATE TABLE `tipo` (
		`tipo` char(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`tipo`)
	  ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
		$this->db->simple_query($mSQL);
	}

}
?>
