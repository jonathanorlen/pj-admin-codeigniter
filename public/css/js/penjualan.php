<?php $user = $this->session->userdata('cashiersession'); ?>
<div id="fx-container" class="fx-opacity">
	<div id="page-content" class="block" style="min-height:650px;">
		<!-- Start Content -->
		<div class="row">
			<div class="col-sm-12">
				<div class="row" style='margin-bottom:10px;'>
					<div class="col-sm-3">
						<button class="btn btn-block btn-lg btn-primary" onClick="browseButton()"><i class="icon-reorder"></i> HOME</button>
					</div>
					<div class="col-sm-3">
						<button class="btn btn-block btn-lg btn-primary" onClick="searchButton()"><i class="icon-search"></i> SEARCH</button>
					</div>
					<div class="col-sm-3">
						<button class="btn btn-block btn-lg btn-primary" onClick="scanButton()"><i class="icon-barcode"></i> SCAN</button>
					</div>
					<div class="col-sm-3">
						<button class="btn btn-block btn-lg btn-primary" data-toggle="modal" href="#modal-tutup"><i class="icon-money"></i> TUTUP KASIR</button>
					</div>
				</div>
				<div class="row" style='margin-bottom:10px; display:none;'>
					<div class="col-sm-6">
						<button class="btn btn-block btn-lg btn-primary" onClick="exportButton()"><i class="icon-search"></i>EXPORT</button>
					</div>
					<div class="col-sm-6">
						<button class="btn btn-block btn-lg btn-primary" onClick="syncButton()"><i class="icon-reorder toggle-bars"></i> SYNC DATA</button>
					</div>
				</div>
				<div class="block full" style="margin-top:10px;" id="import-div">
					<div class="alert alert-info alert-dismissable">
						<h4><i class="icon-info-sign"></i> Info</h4> Silahkan Upload Data Produk dan Masukkan Keycode yang Anda Dapatkan melalui Kantor Pusat - <a href="javascript:void(0)" class="alert-link">File Berupa CSV</a>!
					</div>
					<form action="" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return false;">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-asterisk"></i></span>
								<input type="password" id="example-password3" name="example-password3" class="form-control">
								<span class="input-group-addon">Keycode</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="example-file-input">File input</label>
							<div class="col-md-5">
								<input type="file" id="example-file-input" name="example-file-input">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-5 col-md-offset-2">
								<button type="reset" class="btn btn-default"><i class="icon-remove"></i> Reset</button>
								<button type="submit" class="btn btn-primary"><i class="icon-arrow-right"></i> Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div class="block full" style="margin-top:10px;" id="export-div">
					<div class="alert alert-info alert-dismissable">
						<h4><i class="icon-info-sign"></i> Info</h4> Silahkan Masukkan Keycode dan generate file CSV Produk - <a href="javascript:void(0)" class="alert-link">File Berupa CSV</a>!
					</div>
					<form action="" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return false;">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-asterisk"></i></span>
								<input type="password" id="example-password3" name="example-password3" class="form-control">
								<span class="input-group-addon">Keycode</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-5 col-md-offset-2">
								<button type="reset" class="btn btn-default"><i class="icon-remove"></i> Reset</button>
								<button type="submit" class="btn btn-primary"><i class="icon-arrow-right"></i> Generate and Sends</button>
							</div>
						</div>
					</form>
				</div>
				<div class="block full" style="margin-top:10px;" id="sync-div">
					<div class="alert alert-info alert-dismissable">
						<h4><i class="icon-info-sign"></i> Info</h4> Silahkan tunggu hingga proses sinkronisasi selesai (100%)
					</div>
					<div class="bars-container">
						<h4>Sedang dalam proses</h4>
						
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">80%</div>
						</div>
					</div>
				</div>
				<div id="selling-div">
				<div class="block">
					<div class="row">
						<div class="col-sm-12">
							<blockquote>
								<p><i class="icon-list"></i> PENJUALAN</p>
							</blockquote>
						</div>
					</div>
				</div>
				<div class="block">
					
					<div class="row">
						<div class="col-sm-4">
							<blockquote>
								<p><i class="icon-laptop dataNote"></i></p>
							</blockquote>
						</div>
						<div class="col-sm-4">
							<blockquote>
								<p><i class="icon-file-text dataInvoice"></i></p>
							</blockquote>
						</div>
						<div class="col-sm-4">
							<blockquote>
								<p><i class="icon-user"></i>&nbsp;<?php echo $user[0]->nama; ?></p>
							</blockquote>
						</div>
					</div>
					<div class="row">
						<div class="block-section">
							<div class="input-group input-group-lg">
								<input id="id_product" name="id_product" class="form-control" placeholder="Scan Barcode!" type="text">
								<div class="input-group-btn">
									<button class="btn btn-default"><i class="icon-barcode icon-fixed-width"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table id="general-table" class="table table-stripped">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Product</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Disc</th>
									<th>Subtotal</th>
									<th class="text-center">Ubah</th>
									<th class="text-center">Hapus</th>
								</tr>
							</thead>
							<tbody class="dataSelling">
								<tr>
								  	<td colspan="8" align="center" style="font-size:14px;font-weight:bold;">No Data Available</td>
								</tr>
								<!-- <tr>
									<td>1</td>
									<td>Marimas Buah</td>
									<td>2</td>
									<td>5000</td>
									<td>10%</td>
									<td>10000</td>
						            <td id="r1c1" data-id="1" data-nama="Edit Marimas Buah 1" align="center">
						            	<div class="btn-group btn-group-xs">
											<a class="btn btn-default" title="" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Edit">
												<i class="icon-edit"></i>
												Ubah Qty
											</a>
										</div>
									</td>
						            <td id="r1c2" data-id="1" data-nama="Del Marimas Buah 1" align="center">
										<div class="btn-group btn-group-xs">
											<a class="btn btn-default" title="" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Delete">
												<i class="icon-remove"></i>
												Hapus
											</a>
										</div>
						            </td>
						        </tr> -->
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="alert alert-success">
								<h4 style="margin-top:10px;">
									<strong>TAX : </strong>
									<span class="pull-right">Rp. 1.000.000,00</span>
								</h4>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="alert alert-success">
								<h4 style="margin-top:10px;">
									<strong>DISC : </strong>
									<span class="pull-right">Rp. 1.000.000,00</span>
								</h4>
							</div>
						</div>
					</div>
					<div class="alert alert-success">
						<h2 style="margin-top:10px;">
							<strong>Total : </strong>
							<span class="pull-right">Rp. 1.000.000.000,00</span>
						</h2>
					</div>
					<div class="row"  style="margin-bottom: 10px;">
						<div class="col-sm-6">
							<button class="btn btn-block btn-lg btn-danger">VOID</button>
						</div>
						<div class="col-sm-6">
							<button class="btn btn-block btn-lg btn-primary">SUSPEND</button>
						</div>
					</div>
					<div class="row"  style="margin-bottom: 20px;">
						<div class="col-sm-12">
							<button class="btn btn-block btn-lg btn-success" onClick="paymentButton()">PAY</button>
						</div>
					</div>
				</div>
				</div>

				<div class="block full" style="margin-top:10px;" id="payment-div">
					<div class="row">
						
					</div>
					<div class="row">
						<div class="col-sm-6">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td class="col-xs-12">
											<div class="row text-center">
												<div class="col-md-12">
													<h4>Total</h4>
													<h2 class="text-success">Rp. 950.000,00</h2>
												</div>
												<br/>
												<div class="col-md-12">
													<h4>Dibayar</h4>
													<h2 class="text-success">Rp. 1.000.000,00</h2>
												</div>
												<br/>
												<div class="col-md-12">
													<h4>Kembalian</h4>
													<h2 class="text-warning">Rp. 50.000,00</h2>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-sm-6 pull-right">
							<div class="row" style="margin-bottom: 10px;">
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-md-12">
											
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<select id="example-select selling_pay" name="example-select" class="form-control selling_pay" size="1" style="height:45px;">
												<option value="0">Pilih Pelanggan</option>
												<option value="2">Pak Joko</option>
												<option value="3">Pak Tejo</option>
												<option value="3">Bu Maimunah</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<select id="example-select" name="example-select" class="form-control" size="1" style="height:45px;">
												<option value="0">Pilih Cara Pembayaran</option>
												<option value="2">Cash</option>
												<option value="3">Giro</option>
												<option value="3">Voucher</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<input id="search-term" name="search-term" class="form-control" placeholder="Bayar Sejumlah" type="text" style="height:45px;">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<input id="search-term" name="search-term" class="form-control" placeholder="Diskon" type="text" style="height:45px;">
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-sm-12">
									<button onclick="alert('Sukses, Proses Cetak Nota!');browseButton();return false;" class="btn btn-block btn-lg btn-primary">Bayar</button>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="block full" style="margin-top:10px;" id="browse-div">
					<div class="row">
						<div class="col-md-4" style="margin-top: -30px;">
							<h4 class="sub-header">CATEGORIES</h4>
							<div class="ms-message-list list-group">
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
							</div>
						</div>
						<div class="col-md-8" style="margin-top: -30px;">
							<h4 class="sub-header">LIST ITEMS</h4>
							<div class="ms-message-list list-group">
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="block full" style="margin-top:10px;" id="search-div">
					<div class="row">
						<div class="block-section">
							<form action="page_ready_search_results.html" method="post">
								<div class="input-group input-group-lg">
									<div class="input-group-btn">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="min-width:150px;">All Categories <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li class="active">
												<a href="javascript:void(0)"><i class="icon-ok"></i> All Categories</a>
											</li>
											<li class="divider"></li>
											<li><a href="javascript:void(0)">Users</a></li>
											<li><a href="javascript:void(0)">Projects</a></li>
											<li><a href="javascript:void(0)">Sites</a></li>
										</ul>
									</div>
									<input id="search_sale" name="search-term" class="form-control search_sale" placeholder="Search.." type="text">
									<div class="input-group-btn">
										<button type="submit" class="btn btn-default"><i class="icon-search icon-fixed-width"></i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" style="margin-top: -30px;">
							<h4 class="sub-header">SEARCH RESULT</h4>
							<div class="ms-message-list list-group">
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
								<a href="javascript:void(0)" class="list-group-item" >
									<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-left" width="50" height="50">
									<h4 class="list-group-item-heading pull-right"><strong>500.000</strong></h4>
									<h4 class="list-group-item-heading" style="padding-left:60px; min-height: 45px; max-width:70%;">Judul Produk Akan Ditaruh Disini</h4>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="block full" style="margin-top:10px;" id="scan-div">
					<div class="row">
						<div class="block-section">
							<form action="page_ready_search_results.html" method="post">
								<div class="input-group input-group-lg">
									<input id="search-term" name="search-term" class="form-control" placeholder="Barcode.." type="text">
									<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="icon-barcode icon-fixed-width"></i></button>
								</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row" style="border-top:1px dotted black;">
						<div class="list-group">
							<a href="javascript:void(0)" class="list-group-item" style="">
							<h4 class="list-group-item-heading">
								<strong>Marimas Buah</strong>
							</h4>
							<img src="img/template/avatar2.jpg" alt="Avatar" class="media-object pull-right" width="150px" height="150px" style="margin-right:35px;">
							<p class="list-group-item-text">
								<table id="general-table" class="table table-stripped" style="max-width:60%;">
									<tbody>
										<tr>
											<td>Harga</td>
											<td>500.000</td>
										</tr>
										<tr>
											<td>Diskon</td>
											<td>-</td>
										</tr>
										<tr>
											<td>Stock</td>
											<td>Ada</td>
										</tr>
									</tbody>
								</table>
							</p>
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- End Content -->
	</div>
	<footer class="clearfix">
		<div class="pull-right">
			Design and Developed by <a target="_blank" href="http://www.utomosakti.com" target="_blank">CV. Utomo Sakti</a>
		</div>
		<div class="pull-left">
			<span id="year-copy"></span> &copy; <a target="_blank" href="http://www.basmallah.com" target="_blank">Basmallah</a>
		</div>
	</footer>
</div>

<div id="modal-regular" class="modal" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buka Kasir</h4>
            </div>
            <div class="modal-body">
					<div class="row" style="margin-bottom: 10px;">
						<div class="form-horizontal">
							<div class="form-group" style="display:none;">
								<div class="col-md-12">
									<input id="invoice" name="invoice" class="form-control buka_kasir" placeholder="Cashdraw" type="text" style="height:45px;">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<input id="awal" name="awal" class="form-control awal" placeholder="Kas Awal" type="text" style="height:45px;">
								</div>
							</div>
						</div>
					</div>
				</div>
            <div class="modal-footer">
            		<div class="row" style="margin-bottom: 10px;">
						<div class="col-sm-12">
							<button onclick="open_cash();" class="btn btn-block btn-lg btn-primary">Buka Kasir</button>
						</div>
					</div>
            </div>
        </div>
    </div>

</div>

<div id="modal-add" class="modal" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Transaction</h4>
            </div>
            <div class="modal-body">
					<div class="row" style="margin-bottom: 10px;">
						<div class="form-horizontal">
							<div class="form-group">
								<div class="col-md-12">
									<input id="invoice" name="invoice" class="form-control invoice" placeholder="Invoice" type="text" style="height:45px;">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<input id="kas" name="kas" class="form-control kas" placeholder="Cashdraw" type="text" style="height:45px;">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<input id="barcode" name="barcode" class="form-control barcode" placeholder="Barcode" type="text" style="height:45px;">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<input id="qty" name="qty" class="form-control qty" placeholder="Qty" type="text" style="height:45px;">
								</div>
							</div>
						</div>
					</div>
				</div>
            <div class="modal-footer">
            		<div class="row" style="margin-bottom: 10px;">
						<div class="col-sm-12">
							<button onclick="add_transaction();" class="btn btn-block btn-lg btn-primary">Tambahkan</button>
						</div>
					</div>
            </div>
        </div>
    </div>

</div>

<div id="modal-tutup" class="modal" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title">Tutup Kasir</h4>
            </div>
            <div class="modal-body">
					<div class="row" style="margin-bottom: 10px;">
						<div class="form-horizontal">
							<div class="form-group">
								<div class="col-md-12">
									<input id="tutup_kasir" name="search-term" class="form-control tutup_kasir" placeholder="Kas Akhir" type="text" style="height:45px;">
								</div>
							</div>
						</div>
					</div>
				</div>
            <div class="modal-footer">
				<div class="row" style="margin-bottom: 10px;">
					<div class="col-sm-12">
						<button onclick="alert('Sukses, Kasir Berhasil Ditutup!');$('#modal-tutup').modal('hide');tutupKasir();return false;" class="btn btn-block btn-lg btn-primary">Tutup Kasir</button>
					</div>
				</div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
var b4 = "";
var col = 2;
var row = 6;

function bg() {
    var rc = "r" + row + "c" + col;
    if (b4 == "") b4 = rc;
    $("#"+b4).css("backgroundColor","white");
    $("#"+rc).css("backgroundColor","green");
    //$("#id_product").val($("#"+rc).css("backgroundColor","green").data("id"));
    b4 = rc;
}


function processKeyDown(e) {
    var keyCode;

    if(e.which) { 
        keyCode = e.which;
    } else {
        alert("Unknown event type.");
        return ;
    }
    processKeyHandle(keyCode);
}

function processKeyHandle(keyCode) {
    var nc = 0;
    switch(keyCode) {
    case VK_LEFT :
        if (col > 1) col--;
        bg();
        break;
    case VK_UP :
        if (row > 1) row--;
        bg();
        break;
    case VK_RIGHT :
        if (col < 2) col++;
        bg();
        break;
    case VK_DOWN :  
        if (row < 5) row++;
        bg();
        break;
    case VK_ENTER : 
        //$("#id_product").val($("#"+b4).data("nama"));
        break;
    }
}

$(document).ready(function($) {
	$('#id_product').on('change',function(){
		var product = $('#id_product').val();
		var kas = $.trim($(".dataNote").html());
		var inv = $.trim($(".dataInvoice").html());

		$(".invoice").val(inv);
		$(".kas").val(kas);
		$(".barcode").val(product);
		$('#modal-add').modal('show');
		$("#qty").focus();
		$('#id_product').val('');
		return false;
	}); 

	$('#modal-regular').modal({ backdrop: 'static', keyboard: false }); 
});

function checking(){
	var url = "<?php echo base_url($this->cname); ?>/cashdraw_check";
	var form_data = {
		is_ajax: 'kas'
	};
	$.ajax({
		type: "POST",
		url: url,
		data: form_data,
		success: function(pesan)
		{
			//alert(pesan);
			data = pesan.split("|");
			dataValid=data[0];
			dataStatus=data[1];
			dataCash=data[2];
			if(dataValid == 1){
				$("#id_product").focus();
				$('#modal-regular').modal('hide');
				$(".dataNote").html(dataCash);
				if(dataStatus == 'temporary'){
					var cash = $(".dataNote").html();
					var urlTmp = "<?php echo base_url($this->cname); ?>/temporary_check";
					var form_dataTmp = {
						cash : $.trim(dataCash),
						is_ajax: 'temporary'
					};
					$.ajax({
						type: "POST",
						url: urlTmp,
						data: form_dataTmp,
						success: function(msg)
						{
							data = msg.split("|");
							dataValid2=data[0];
							dataInvoice2=data[1];
							//alert(msg);
							if(dataValid2==0){
								$("#id_product").focus();
								var urlInv = "<?php echo base_url($this->cname); ?>/invoice_request";
								var form_dataInv = {
									kas: $.trim(dataCash),
									is_ajax: 'request'
								};
								$.ajax({
									type: "POST",
									url: urlInv,
									data: form_dataInv,
									success: function(inv)
									{
										data = inv.split("|");
										$(".dataInvoice").html(data[0]);
									}
								});
							}else if(dataValid2==1){
								//alert(msg);
								$("#id_product").focus();
								$(".dataInvoice").html(dataInvoice2);
		                        var urlDataTmp = "<?php echo base_url($this->cname); ?>/get_temp_data";
		                        var form_dataListTmp = {
		                            kas: $.trim(dataCash),
		                            inv: $.trim(dataInvoice2),
		                            is_ajax: 'temporary'
		                        };
		                        $.ajax({
		                            type: "POST",
		                            url: urlDataTmp,
		                            data: form_dataListTmp,
		                            success: function(temp) {
		                            	//alert(temp);
		                                var data = temp.split("|");
		                                $(".dataSelling").html(data[0]);
		                                $(".totalSelling").html(data[1]);
		                                $("#inputTotal").val(data[1]);
		                                $("#dumpTotal").val(data[1]);
		                                $(".dataTotal").html(data[1]);
		                                //$(".dataTotal").mask("000.000.000.000.000", {
		                                //     reverse: true
		                                // });
		                            }
		                        });
		                        
							}else{
								alert('Software Error! Harap segera hubungi Admin atau Teknisi Outlet!');
							}
						}
					});
				}else if(dataStatus == 'submited'){
					// $(".chosenNew").hide();
					// $(".chosenAccept").hide();
					// $(".dataNote").html('Pending');
					// $(".open").hide();
					// $(".kasInput").hide();
					// $(".chosenSubmit").show();
				}else if(dataStatus == 'accepted'){
					// $(".chosenNew").hide();
					// $(".chosenSubmit").hide();
					// $(".dataNote").html('Accepted');
					// $(".open").hide();
					// $(".kasInput").hide();
					// $(".chosenAccept").show();
				}
			}
			else if(dataValid == 0){
				$('#modal-regular').modal('show');
				 
				$(".buka_kasir").focus();
				var urlCont = "<?php echo base_url($this->cname); ?>/cashdraw_request";
				var form_dataCont = {
					is_ajax: 'request'
				};
				$.ajax({
					type: "POST",
					url: urlCont,
					data: form_dataCont,
					success: function(msg)
					{
						//alert(msg);
						data = msg.split("|");
						$(".dataNote").html(data[0]);
						// $(".statTemp").html(data[1]);
						$("#invoice").val(data[0]);
					}
				});
			}
		}
	})
	setTimeout('checking()', 10000);
}

	$(window).load(function() {
		checking();
	});

	function open_cash(){
		var cash = $("#invoice").val();
		var awal = $('#awal').val();
		
		if(cash && awal){
			var url = "<?php echo base_url($this->cname); ?>/open_cash";
			var form_data = {
				inv: $.trim(cash),
				awal: $.trim(awal),
				is_ajax: 'open'
			};
			$.ajax({
				type: "POST",
				url: url,
				data: form_data,
				success: function(data)
				{
					//alert(data);
					if (data==1){
						$('#modal-regular').modal('hide');
					}
					else if(data==2){
						addData();
					}
					else if(data==0){
						addGagal();
					}
					else{
						inpoServer();
					}
				}
			});
		}else{
			$(".chosenValidate").show();
		}
		return false;
	}

	function add_transaction(){
		var invoice = $(".invoice").val();
		var cash = $('.kas').val();
		var barcode = $('.barcode').val();
		var qty = $('.qty').val();
		
		if(invoice && cash && barcode && qty){
			var url = "<?php echo base_url($this->cname); ?>/add_transaction";
			var form_data = {
				inv: $.trim(invoice),
				cash: $.trim(cash),
				barcode: $.trim(barcode),
				qty: $.trim(qty),
				is_ajax: 'open'
			};
			$.ajax({
				type: "POST",
				url: url,
				data: form_data,
				success: function(data)
				{
					alert(data);
					if (data==1){
						$("#barcode").focus();
					}
					else if(data==2){
						addData();
					}
					else if(data==0){
						addGagal();
					}
					else{
						inpoServer();
					}
				}
			});
		}else{
			$(".chosenValidate").show();
		}
		return false;
	}


</script>
<script>
$(function(){
	//$('#modal-regular').modal('show');
	$("#awal").focus();
	$(".buka_kasir").focus();
	$("#modal-compose").on("shown.bs.modal",function(){$(".modal-select-chosen").chosen({width:"100%"})}),$(".ms-message-list").slimScroll({height:610,color:"#000000",size:"3px",touchScrollStep:750});var e=$(".ms-categories");$("a",e).click(function(){$("li",e).removeClass("active"),$(this).parent().addClass("active"),$(this).data("cat")});begin();});

		function toggleButton(){
			if($('.hide-key').is(':visible')){
				$('.hide-key').hide();
			} else {
				$('.hide-key').show();
			}
		}
		function tutupKasir(){
			setTimeout(function() {window.location = "dashboard.html"},500);
		}
		function browseButton(){
			$('#head-div').slideUp();
			$('#browse-div').slideUp();
			$('#search-div').slideUp();
			$('#scan-div').slideUp();
			$('#payment-div').slideUp();
			$('#selling-div').slideDown();
			$('#import-div').slideUp();
			$('#export-div').slideUp();
			$('#sync-div').slideUp();
		}
		function paymentButton(){
			$('#head-div').slideDown();
			$('#browse-div').slideUp();
			$('#search-div').slideUp();
			$('#scan-div').slideUp();
			$('#payment-div').slideDown();
			$('#selling-div').slideUp();
			$('#import-div').slideUp();
			$('#export-div').slideUp();
			$('#sync-div').slideUp();
			$("#selling_pay").focus();
			$(".selling_pay").focus();
		}
		function scanButton(){
			$('#head-div').slideDown();
			$('#browse-div').slideUp();
			$('#search-div').slideUp();
			$('#scan-div').slideDown();
			$('#payment-div').slideUp();
			$('#selling-div').slideUp();
			$('#import-div').slideUp();
			$('#export-div').slideUp();
			$('#sync-div').slideUp();
		}
		function searchButton(){
			$('#head-div').slideUp();
			$('#browse-div').slideUp();
			$('#search-div').slideDown();
			$('#scan-div').slideUp();
			$('#payment-div').slideUp();
			$('#selling-div').slideUp();
			$('#import-div').slideUp();
			$('#export-div').slideUp();
			$('#sync-div').slideUp();
			$("#search_sale").focus();
			$(".search_sale").focus();
		}
		function begin(){
			$('#browse-div').slideUp();
			$('#search-div').slideUp();
			$('#scan-div').slideUp();
			$('#payment-div').slideUp();
			$('.hide-key').slideUp();
			$('#selling-div').slideDown();
			$('#sync-div').slideUp();
			$('#import-div').slideUp();
			$('#export-div').slideUp();
		}
		function syncButton(){
			$('#head-div').slideDown();
			$('#browse-div').slideUp();
			$('#tambah-div').slideUp();
			$('#import-div').slideUp();
			$('#export-div').slideUp();
			$('#search-div').slideUp();
			$('#scan-div').slideUp();
			$('#sync-div').slideDown();
			$('#selling-div').slideUp();
			generate();
		}
		function importButton(){
			$('#head-div').slideDown();
			$('#browse-div').slideUp();
			$('#tambah-div').slideUp();
			$('#import-div').slideDown();
			$('#export-div').slideUp();
			$('#search-div').slideUp();
			$('#scan-div').slideUp();
			$('#sync-div').slideUp();
			$('#selling-div').slideUp();
		}
		function exportButton(){
			$('#head-div').slideDown();
			$('#browse-div').slideUp();
			$('#tambah-div').slideUp();
			$('#import-div').slideUp();
			$('#export-div').slideDown();
			$('#search-div').slideUp();
			$('#scan-div').slideUp();
			$('#sync-div').slideUp();
			$('#selling-div').slideUp();
		}

      $(document).on('keydown', function(e){
        var key = e.which;
        if(e.ctrlKey && key == 66){ //CTRL+B
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+P!');
            browseButton();
            return false;
        }else if(e.ctrlKey && key == 83){ //CTRL+S
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+R!');
            searchButton();
            return false;
        }else if(e.ctrlKey && key == 67){ //CTRL+C
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+H!');
            scanButton();
            return false;
        }else if(e.ctrlKey && key == 80){ //CTRL+P
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+U!');
            paymentButton();
            return false;
        }else if(e.ctrlKey && key == 84){ //CTRL+T
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+U!');
            $('#modal-tutup').modal('show');
			$("#tutup_kasir").focus();
			$(".tutup_kasir").focus();
            return false;
        }else if(key == 27){
        	setTimeout(function() {window.location = "dashboard.html"},500);
        }else{
        	return true;
        }
      });
      $(document).on('keyup', function(e){
          var key = e.which;
        if(e.ctrlKey && key == 66){ //CTRL+B
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+P!');
            browseButton();
            return false;
        }else if(e.ctrlKey && key == 83){ //CTRL+S
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+R!');
            searchButton();
            return false;
        }else if(e.ctrlKey && key == 67){ //CTRL+C
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+H!');
            scanButton();
            return false;
        }else if(e.ctrlKey && key == 80){ //CTRL+P
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+U!');
            paymentButton();
            return false;
        }else if(key == 27){
        	setTimeout(function() {window.location = "dashboard.html"},500);
        }else{
        	return true;
        }
      });
      $(document).on('keypress', function(e){
          var key = e.which;
        if(e.ctrlKey && key == 66){ //CTRL+B
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+P!');
            browseButton();
            return false;
        }else if(e.ctrlKey && key == 83){ //CTRL+S
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+R!');
            searchButton();
            return false;
        }else if(e.ctrlKey && key == 67){ //CTRL+C
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+H!');
            scanButton();
            return false;
        }else if(e.ctrlKey && key == 80){ //CTRL+P
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            console.log('Ctrl+U!');
            paymentButton();
            return false;
        }else if(key == 27){
        	setTimeout(function() {window.location = "dashboard.html"},500);
        }else{
        	return true;
        }
      });
		


    </script>
	
	<script type="text/javascript">
		$(document).ready(function() {
		// Create two variable with the names of the months and days in an array
		var monthNames = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ]; 
		var dayNames= ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"]

		// Create a newDate() object
		var newDate = new Date();
		// Extract the current date from Date object
		newDate.setDate(newDate.getDate());
		// Output the day, date, month and year    
		$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

		setInterval( function() {
			// Create a newDate() object and extract the seconds of the current time on the visitor's
			var seconds = new Date().getSeconds();
			// Add a leading zero to seconds value
			$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
			},1000);
			
		setInterval( function() {
			// Create a newDate() object and extract the minutes of the current time on the visitor's
			var minutes = new Date().getMinutes();
			// Add a leading zero to the minutes value
			$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
		    },1000);
			
		setInterval( function() {
			// Create a newDate() object and extract the hours of the current time on the visitor's
			var hours = new Date().getHours();
			// Add a leading zero to the hours value
			$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
		    }, 1000);
			
		}); 
	</script>