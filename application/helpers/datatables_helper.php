<?php 
/*
 * function that generate the action buttons edit, delete
 * This is just showing the idea you can use it in different view or whatever fits your needs
 */
function get_detail_validasi($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="validasi/'.$id.'" data-toggle="tooltip" title="Validasi" class="btn btn-xs green"><i class="fa fa-check-square-o"></i> Validasi</a>
    </div>
    ';
    
    return $html;
}

function detail_tervalidasi($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs blue"><i class="fa fa-eye"></i> Detail</a>
    </div>
    ';
    
    return $html;
}

function get_del_id($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a style="padding:3.5px;" onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-trash"></i></a>
    </div>
    ';
    
    return $html;
}
function validasi_penjualan($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        
        <a data-toggle="tooltip" onclick="actDelete('.$id.')" id="'.$id.'" title="Hapus" class="btn btn-small btn-info"><i class="fa fa-check"></i>  Sesuai</a>
        <a data-toggle="tooltip" id="'.$id.'" title="Validasi Penjualan" class="btn adetail btn-small btn-danger"><i class="fa fa-close"></i>Tidak</a>
    </div>
    ';
    
    return $html;
}

function get_url_detail_edit_delete($url,$id){
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_'.$url.'/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
        <a href="'.$url.'/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> edit</a>
        <a style="padding:3.5px;" onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-xs red"><i class="fa fa-trash"> delete</i></a>
    </div>
    ';
    
    return $html;
}
function get_detail_edit_delete_stok($position,$id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$position.'/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    <a href="ubah/'.$position.'/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    <a key="'.$id.'" id="hapus" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"></i></a>
    </div>
    ';
    
    return $html;
}

function detail_stok($position,$id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$position.'/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit_delete($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
        <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
        <a style="padding:3.5px;" onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"></i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit_delete_master_keu($uri, $id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_'.$uri.'/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
        <a href="tambah_'.$uri.'/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> edit</a>
        <a style="padding:3.5px;" onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-xs red"><i class="fa fa-trash"> delete</i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit_delete_keu($uri, $id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_'.$uri.'/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit_delete_string($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    <a href="tambah/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    <a onclick="actDelete(\''.$id.'\')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"></i></a>
    </div>
    ';
    
    return $html;
    // $ci =& get_instance();

    // $html = '
    // <div class="btn-group">
    //     <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
    //     <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> edit</a>
    //     <a style="padding:3.5px;" onclick="actDelete(\''.$id.'\')" data-toggle="tooltip" title="Delete" class="btn btn-xs red"><i class="fa fa-trash"> delete</i></a>
    // </div>
    // ';
    
    // return $html;
}

function get_detail_edit_hapus($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
        <a href="edit/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
        <a onclick="actDelete(\''.$id.'\')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"></i></a>
    </div>
    ';
    
    return $html;
}


function get_detail_edit_delete_reservasi($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_reservasi/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
        <a href="reservasi/'.$id.'/edit" data-toggle="tooltip" title="Edit" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> edit</a>
        <a style="padding:3.5px;" onclick="actDelete(\''.$id.'\')" data-toggle="tooltip" title="Cancel" class="btn btn-xs red"><i class="fa fa-trash"> cancel</i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit_delete_string_bj($kode_unit,$kode_rak,$id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail/'.$kode_unit.'/'.$kode_rak.'/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
        <a href="tambah/'.$kode_unit.'/'.$kode_rak.'/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> edit</a>
        <a style="padding:3.5px;" onclick="actDelete(\''.$id."|".$kode_unit."|".$kode_rak.'\')" data-toggle="tooltip" title="Delete" class="btn btn-xs red"><i class="fa fa-trash"> delete</i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
        <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> edit</a>
    </div>
    ';
    
    return $html;
}

function cek_status($id)
{
    if($id=='1')
        return '<span class="label label-info">AKTIF</span>';
    else 
        return '<span class="label label-danger">NON AKTIF</span>';
}

function cek_status_piutang($id)
{
    if($id!='0')
        return '<span class="label label-warning">Angsuran</span>';
    else 
        return '<span class="label label-success">Lunas</span>';
}
function cek_status_ro($id)
{
    if($id=='')
        return '<span class="label label-info">Menunggu</span>';
    else if($id=='proses')
        return '<span class="label label-warning">Proses</span>';
    else if($id=="batal")
        return '<span class="label label-danger">Batal</span>';
    else
        return '<span class="label label-success">Selesai</span>';
}

function get_edit_del($id,$kode)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" data-toggle="tooltip" title="Edit" class="btn purple btn-xs btn-default"><i class="fa fa-pencil"></i> Edit</a>
    <a style="padding:3.5px;" onclick="actDelete('.$id.',\''.$kode.'\')" data-toggle="tooltip" title="Delete" class="btn btn-xs red"><i class="fa fa-trash"> delete</i></a>
    </div>
    ';
    
    return $html;
}

function get_edit_del_bj($id,$kode_unit,$kode_rak,$kode_bahan_jadi)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" data-toggle="tooltip" title="Edit" class="btn purple btn-xs btn-default"><i class="fa fa-pencil"></i> Edit</a>
    <a style="padding:3.5px;" onclick="actDelete('.$id.',\''.$kode_unit.'\',\''.$kode_rak.'\',\''.$kode_bahan_jadi.'\')" data-toggle="tooltip" title="Delete" class="btn btn-xs red"><i class="fa fa-trash"> delete</i></a>
    </div>
    ';
    
    return $html;
}

function get_edit_del_id($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> </a>
    <a style="padding:3.5px;" onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-trash"></i> </a>
    </div>
    ';
    
    return $html;
}
function get_edit_id($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> </a>
    
    </div>
    ';
    
    return $html;
}

function get_edit_del_id_temp($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" data-toggle="tooltip" title="Edit" class="btn btn-primary"> Edit</a>
    <a style="padding:4px;height: 34px;" onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-warning"> Delete</a>
    </div>
    ';
    
    return $html;
}

function get_del_id_temp($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    
    <a style="padding:4px;height: 34px;" onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-warning"> Delete</a>
    </div>
    ';
    
    return $html;
}

function get_del_temp($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a style="padding:3.5px;" onclick="actDeleteTemp('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-xs red"><i class="fa fa-trash"> delete</i></a>
    </div>
    ';
    
    return $html;
}


function get_detail($id)
{
    
     $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
    
}
function get_detail_cari($id)
{
    
     $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail_cari/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
    
}
function get_detail_hut($id)
{
    
     $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail_daftar/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
    
}
function get_detail_retur_penjualan($id)
{
    
     $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail_retur/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
    
}
function get_detail_retur_pembelian($id)
{
    
     $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail_retur_pembelian/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
    
}
function get_detail_gudang($id)
{
    
     $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail_stok_gudang/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
    
}

function get_detail_penjualan($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="laporan/detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}
function get_detail_menu($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="laporan/detail_menu/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_persediaan($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_stok/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-xs green"><i class="fa fa-search"></i> detail</a>
    </div>
    ';
    
    return $html;
}

function get_detail_print($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    <a href="print_po/'.$id.'" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-icon-only btn-circle blue"><i class="fa fa-print"></i></a>
    </div>
    ';
    
    return $html;
    
    
}
function get_detail_print_edit($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    <a href="print_po/'.$id.'" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-icon-only btn-circle blue"><i class="fa fa-print"></i></a>
    <a href="edit/'.$id.'" id="edit" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    </div>
    ';
    
    return $html;
    
    
}


function get_detail_mutasi($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_mutasi/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}
function get_detail_mutasi_gudang($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_mutasi_gudang/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}
function get_detail_mutasi_kitchen($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_mutasi_kitchen/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_stok($kode_unit, $kode_rak ,$kode_bahan)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="../detail/'.$kode_unit.'/'.$kode_rak.'/'.$kode_bahan.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}

function get_validasi_opname_gudang($uri, $id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="validasi_opname_gudang/'.$uri.'/'.$id.'" data-toggle="tooltip" title="Validasi" class="btn btn-xs green"><i class="fa fa-check-square-o"></i>  Validasi</a>
    </div>
    ';
    
    return $html;
}
function get_validasi_opname_kitchen($uri, $id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="validasi_opname_kithcen/'.$uri.'/'.$id.'" data-toggle="tooltip" title="Validasi" class="btn btn-xs green"><i class="fa fa-check-square-o"></i>  Validasi</a>
    </div>
    ';
    
    return $html;
}

function get_detail_spoil($uri, $id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_spoil/'.$id.'/'.$uri.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_proses($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
        <a href="proses/'.$id.'" data-toggle="tooltip" title="Proses" class="btn btn-icon-only btn-circle blue"><i class="fa fa-pencil"></i></a>
    </div>
    ';
    
    return $html;
}
function get_detail_valid($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
        <a href="validasi/'.$id.'" data-toggle="tooltip" title="Validasi" class="btn btn-icon-only btn-circle blue"><i class="fa fa-check-square-o"></i></a>
    </div>
    ';
    
    return $html;
}
function get_detail_proses_cari($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
        <a href="detail_cari/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
        <a href="proses/'.$id.'" data-toggle="tooltip" title="Proses" class="btn btn-icon-only btn-circle blue"><i class="fa fa-pencil"></i></a>
    </div>
    ';
    
    return $html;
}

function cek_status_retur($status)
{
    if($status=='menunggu'){
        return '<div class="btn btn-xs red">'.$status.'</div>';
    }
    else {
        return '<div class="btn btn-xs green">'.$status.'</div>';
    }
}

function cek_status_meja($id)
{
    if($id==0)
        return '<span class="label label-success">Kosong</span>';
    else 
        return '<span class="label label-danger">Terpakai</span>';
}

function cek_status_barang($id)
{
    if($id=='menunggu')
        return '<span class="label label-info">Menunggu</span>';
    else if($id=='sesuai')
        return '<span class="label label-success">Sesuai</span>';
    else if($id=="belum divalidasi" || $id=="belum divalidasi 2")
        return '<span class="label label-danger">Belum Divalidasi</span>';
}
?>