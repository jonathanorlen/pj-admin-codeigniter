

<?php 
/*
 * function that generate the action buttons edit, delete
 * This is just showing the idea you can use it in different view or whatever fits your needs
 */
function get_edit_ajax_delete_ajax($id)
{
    // master (setup area, setup product)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" data-toggle="tooltip" title="Edit" class="btn purple btn-xs btn-default"><i class="fa fa-pencil"></i> Edit</a>
    <a onclick="actDelete('.$id.')" data-toggle="tooltip" title="Hapus" class="btn red btn-xs btn-default"><i class="fa fa-remove"></i> Hapus</a>
    </div>
    ';
    
    return $html;
}
function get_personal_delete_ajax($id)
{
    // master (setup area, setup product)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actPersonal('.$id.')" data-toggle="tooltip" title="Personal" class="btn purple btn-xs btn-default"><i class="fa fa-user"></i> Personal</a>
    <a onclick="actDelete('.$id.')" data-toggle="tooltip" title="Hapus" class="btn red btn-xs btn-default"><i class="fa fa-remove"></i> Hapus</a>
    </div>
    ';
    
    return $html;
}



function get_detail_edit_delete($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    <a href="ubah/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    <a key="'.$id.'" id="hapus" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"></i></a>
    </div>
    ';
    
    return $html;
}

function get_edit_delete_item_transaksi($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="ubah_item_transaksi/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> Edit</a>
    <a style="padding:3.5px;" key="'.$id.'" id="hapus" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"> Delete</i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_delete($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i> Detail</a>
    <a style="padding:3.5px;" key="'.$id.'" id="hapus" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"> Delete</i></a>
    </div>
    ';
    
    return $html;
}


function get_detail_69($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="DF-E-68" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i> Detail</a>
    </div>
    ';
    
    return $html;
}


function get_edit_form($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah_68/'.$id.'" key="'.$id.'" id="tambah_68" data-toggle="tooltip" title="DF-E-68" class="btn btn-circle green"><i class="fa fa-pencil"></i> DF-E-68</a>
    <a href="tambah_14/'.$id.'" key="'.$id.'" id="tambah_14" data-toggle="tooltip" title="DF-E-14" class="btn btn-circle yellow"><i class="fa fa-pencil"></i> DF-E-14</a>
    </div>
    ';
    
    return $html;
}

function get_uji_test_form($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="test/'.$id.'" key="'.$id.'" id="tambah_14" data-toggle="tooltip" title="Retest" class="btn btn-circle green"><i class="fa fa-pencil"></i> Test</a>
    </div>
    ';
    
    return $html;
}
function get_uji_retest_form($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="retest/'.$id.'" key="'.$id.'" id="tambah_14" data-toggle="tooltip" title="Retest" class="btn btn-circle red"><i class="fa fa-pencil"></i> Retest</a>
    </div>
    ';
    
    return $html;
}
function get_uji_detail_form($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" key="'.$id.'" id="tambah_14" data-toggle="tooltip" title="Retest" class="btn btn-circle blue"><i class="fa fa-pencil"></i> Detail</a>
    </div>
    ';
    
    return $html;
}

function get_uji_form($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="test/'.$id.'" key="'.$id.'" id="tambah_68" data-toggle="tooltip" title="Test" class="btn btn-circle green"><i class="fa fa-pencil"></i> Test</a>
    <a href="retest/'.$id.'" key="'.$id.'" id="tambah_14" data-toggle="tooltip" title="Retest" class="btn btn-circle yellow"><i class="fa fa-pencil"></i> Retest</a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit_delete_sample($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i> Detail</a>
    <a href="ubah/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> DF-E-68</a>
    <a style="padding:3.5px;" key="'.$id.'" id="hapus" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"> Delete</i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_proses($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i> Detail</a>
    <a href="ubah/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle blue"><i class="fa fa-pencil"></i> Proses</a>
    </div>
    ';
    
    return $html;
}


function get_detail_edit($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    <a href="ubah/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    </div>
    ';
    
    return $html;
}

function get_detail_plan($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="../detailplanuji/'.$id.'" key="'.$id.'" id="detail" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}

function get_edit_plan($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="../ubahplanuji/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    </div>
    ';
    
    return $html;
}

function get_detail($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
    </div>
    ';
    
    return $html;
}

function get_bayar($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="bayar/'.$id.'" data-toggle="tooltip" title="Bayar" class="btn btn-icon-only btn-circle blue"><i class="fa fa-dollar"></i> bayar</a>
    </div>
    ';
    
    return $html;
}

function get_transaksi($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="pos/?uid='.$id.'" data-toggle="tooltip" title="POS Data" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i> POS</a>
    </div>
    ';
    
    return $html;
}

function get_validasi($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actValidasi('.$id.')" data-toggle="tooltip" title="Validasi" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-file-text"></i> Validasi</a>
    </div>
    ';
    
    return $html;
}

function get_berangkat($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actPrint('.$id.')" data-toggle="tooltip" title="Print Surat Jalan" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-file-text"></i> Print Surat Jalan</a>
    <a onclick="actBerangkat('.$id.')" data-toggle="tooltip" title="Sudah Terkirim" class="btn btn-icon-only btn-circle green"><i class="fa fa-truck"></i> Sudah Terkirim</a>
    </div>
    ';
    
    return $html;
}

function get_edit_delete($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="ubah/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    <a key="'.$id.'" id="hapus" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"></i></a>
    </div>
    ';
    
    return $html;
}

function get_edit_delete_pembelian($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    <a onclick="actDelete('.$id.')" key="'.$id.'" id="hapus" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"></i></a>
    </div>
    ';
    
    return $html;
}

function get_edit_delete_hutang($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="bayar/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle blue"><i class="fa fa-money"></i> bayar</a>
    </div>
    ';
    
    return $html;
}

function get_edit_delete_add($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> edit</a>
    <a onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"> delete</i></a>
    <a href="tambah_layanan/'.$id.'" data-toggle="tooltip" title="Tambah Layanan" class="btn btn-icon-only btn-circle green"><i class="fa fa-plus"> tambah layanan</i></a>
    </div>
    ';
    
    return $html;
}

function get_edit_delete_ajax($id)
{
    // master (kategori,department,subkategori)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn green btn-xs btn-default"><i class="fa fa-pencil"></i>Edit</a>
    <a onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn red btn-xs btn-default"><i class="fa fa-remove"></i>Delete</a>
    </div>
    ';
    
    return $html;
}

function get_detail_validasi_ajax($id)
{
    // master (kategori,department,subkategori)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actDetail('.$id.')" data-toggle="tooltip" title="Detail" class="btn green btn-xs btn-default"><i class="fa fa-pencil"></i>Detail</a>
    <a onclick="actValidasi('.$id.')" data-toggle="tooltip" title="Validasi" class="btn red btn-xs btn-default"><i class="fa fa-check"></i>Validasi</a>
    </div>
    ';
    
    return $html;
}

function get_delete_ajax($id)
{
    // master (setup area, setup product)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actDelete('.$id.')" data-toggle="tooltip" title="Hapus" class="btn red btn-xs btn-default"><i class="fa fa-remove"></i> Hapus</a>
    </div>
    ';
    
    return $html;
}

function get_remove_ajax($id)
{
    // master (setup area, setup product)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actRemove('.$id.')" data-toggle="tooltip" title="Hapus" class="btn red btn-xs btn-default"><i class="fa fa-remove"></i> Hapus</a>
    </div>
    ';
    
    return $html;
}

function get_edit_ajax($id)
{
    // master (setup area, setup product)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actEdit('.$id.')" data-toggle="tooltip" title="Edit Setup" class="btn btn-icon-only btn-circle btn-default"><i class="fa fa-pencil"></i> Edit Max</a>
    </div>
    ';
    
    return $html;
}

function get_edit($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="ubah/'.$id.'" key="'.$id.'" id="ubah" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
    </div>
    ';
    
    return $html;
}

function get_gaji_detail_edit_delete($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actGaji('.$id.')" data-toggle="tooltip" title="Gaji" class="btn btn-icon-only btn-circle purple"><i class="fa fa-dollar"> gaji</i></a>
    <a href="detail/'.$id.'" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i> detail</a>
    <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> edit</a>
    <a onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"> delete</i></a>
    </div>
    ';
    
    return $html;
}


function get_edit_harga($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah_harga/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> edit</a>
    </div>
    ';
    
    return $html;
}

function get_edit_print($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> edit</a>
    <a href="print_salary/'.$id.'" data-toggle="tooltip" title="Print" class="btn btn-icon-only btn-circle blue"><i class="fa fa-print"></i> print</a>
    </div>
    ';
    
    return $html;
}

function get_button_blended($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle btn-default"><i class="fa fa-pencil"></i> edit</a>
    <a onclick="actUnblend('.$id.')" data-toggle="tooltip" title="unblended" class="btn btn-icon-only btn-circle btn-default"><i class="fa fa-remove"></i> unblended</a>
    </div>
    ';
    
    return $html;
}

function get_detail_edit_print($id)
{
    $ci =& get_instance();
    // $key = paramEncrypt($id);

    $html = '
    <div class="btn-group">
    <a href="edit/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle btn-default"><i class="fa fa-pencil"></i></a>
    <a href="print_faktur/'.$id.'" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-icon-only btn-circle btn-default"><i class="fa fa-print"></i> Print</a>
    </div>  
    ';
    
    return $html;
}

function get_distribusi($id,$status)
{
    // master (kategori,department,subkategori)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    ';
    $html .= '
    <a onclick="actDetail('.$id.')" data-toggle="tooltip" title="Detail" class="btn green btn-xs btn-default"><i class="fa fa-search"></i>Detail</a>
    ';
    if($status == 'valid'){
        $html .= '
        <a href="proses/'.$id.'" data-toggle="tooltip" title="Proses" class="btn red btn-xs btn-default"><i class="fa fa-edit"></i> Proses</a>
        ';  
    }
    $html .= '
    </div>
    ';
    
    return $html;
}

function get_detail_ajax($id)
{
    // master (kategori,department,subkategori)
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a onclick="actDetail('.$id.')" data-toggle="tooltip" title="Detail" class="btn green btn-xs btn-default"><i class="fa fa-pencil"></i>Detail</a>
    </div>
    ';
    
    return $html;
}

function tambah_stok($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah/'.$id.'" data-toggle="tooltip" title="Tambah" class="btn btn-icon-only btn-circle btn-info"><i class="fa fa-plus"></i> Tambah Stok</a>
    </div>
    ';
    
    return $html;
}

function total($quantity,$hpp)
{
    $ci =& get_instance();
    // $key = paramEncrypt($id);

    $total = $quantity * $hpp;
    return format_rupiah($total);
}

function split_json($json)
{
    $array = json_decode($json);
    $result = $array[0];
    $i=1;
    while (@$array[$i]) {
        if( $i%4 == 0)
            $result .= ', </br>'.$array[$i];
        else
            $result .= ', '.$array[$i];
        $i++;
    }
    return $result;
}

function wrap($ket)
{
    $array = explode(" ",$ket);
    $result = $array[0];
    $i=1;
    while (@$array[$i]) {
        if( $i%4 == 0)
            $result .= ' </br>'.$array[$i];
        else
            $result .= ' '.$array[$i];
        $i++;
    }
    return $result;
}

function cek_produk($id)
{
    if($id=='P')
        return '<span class="label label-primary">PRODUK</span>';
    else 
        return '<span class="label label-success">LAYANAN</span>';
}

function cek_status_user($id)
{
    if($id=='1')
        return '<span class="label label-success">Active</span>';
    else 
        return '<span class="label label-danger">Not Active</span>';
}

function cek_status($id)
{
    if($id=='1')
        return '<span class="label label-success">Aktif</span>';
    else 
        return '<span class="label label-danger">Tidak Aktif</span>';
}
function cek_status_validasi_($id)
{
    if($id=='diterima')
        return '<span class="label label-success">Diterima</span>';
    else if($id=='')
        return '<span class="label label-warning">Belum Divalidasi</span>';
    else 
        return '<span class="label label-danger">Tidak Diterima</span>';
}

function cek_transaksi($id)
{
    if($id=='Approve')
        return '<span class="label label-success">APPROVE</span>';
    elseif($id=='Process') 
        return '<span class="label label-primary">PROCESS</span>';
    elseif($id=='Pending')
        return '<span class="label label-warning">PENDING</span>';
    elseif($id=='Cancel')
        return '<span class="label label-danger">Cancel</span>';
}

function cek_status_validasi($id)
{
    if($id=='valid')
        return '<span class="label label-success">Valid</span>';
    else 
        return '';
}

function cek_status_plan($id)
{
    if($id=='planned')
        return '<span class="label label-success">OK</span>';
    else if($id=='re-plan')
        return '<span class="label label-danger">Re-planned</span>';
    else 
        return '';
}

function cek_status_uji($id)
{
    if($id=='tested')
        return '<span class="label label-success">tested</span>';
    else if($id=='retested')
        return '<span class="label label-info">retested</span>';
    else if($id=='re-plan')
        return '<span class="label label-danger">re-plan</span>';
}


function cek_gender($id)
{
    if($id=='M')
        return '<span class="label label-success">Laki-laki</span>';
    else 
        return '<span class="label label-primary">Perempuan</span>';
}

function cek_member($id)
{
    if($id=='yes')
        return '<span class="label label-success">member</span>';
    else 
        return '<span class="label label-danger">non member</span>';
}

function get_status_inventaris($id)
{
    if($id=='BP')
        return '<span class="label label-success">Barang Pokok</span>';
    else 
        return '<span class="label label-primary">Barang Inventaris</span>';
}

function edit_price($id)
{
    $price = json_decode($id);
    return 'harga : '.format_rupiah($price[0]);
    // return 'harga 1: '.format_rupiah($price[0]).' | harga 2: '.format_rupiah($price[1]).' | harga 3: '.format_rupiah($price[2]);
    // if($id=='yes')
    //     return '<span class="label label-success">member</span>';
    // else 
    //     return '<span class="label label-danger">non member</span>';
}

function edit_hp($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="input_harga_produk/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> edit</a>
    </div>
    ';
    
    return $html;
}

function edit_hp2($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="input_harga_paket/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> edit</a>
    </div>
    ';
    
    return $html;
}

function get_edit_delete_print($id)
{
    $ci =& get_instance();

    $html = '
    <div class="btn-group">
    <a href="tambah/'.$id.'" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i> edit</a>
    <a onclick="actDelete('.$id.')" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-remove"> delete</i></a>
    <a href="cetak/'.$id.'" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle green"><i class="fa fa-remove"> delete</i></a>
    </div>
    ';
    
    return $html;
}