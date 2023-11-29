@extends('layouts.app')

@section('content')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Leads</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <form   name="saveform" action="{{ route('dataleads.import') }}" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">                                         
                            @csrf

                            <label class="mt-3" for="">Tanggal Awal:</label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal">

                            <label class="mt-3" for="">Tanggal Akhir:</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir">

                            <div class="form-group mb-4 mt-2">
                                                <label for="" class="form-label">Pilih KCU</label>

<select name="kcu" class="form-control " style="border-color: #01004C;" aria-label=".form-select-lg example"  oninvalid="this.setCustomValidity('Pilih salah satu akses')" oninput="setCustomValidity('')" >
  

<option value="" selected disabled>-- Pilih KCU --</option>
@foreach ($kcu as $item)
        <option value="{{ $item->id }}"{{ old('kcu') == $item->id ? 'selected' : '' }}> {{ $item->nama_kcu }}</option>
    @endforeach
</select>

                                            </div>
  
  <div class="form-group mt-3">
    <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
  </div>
  <button type="submit" class="btn btn-primary btn-sm mb-2">Import Data</button>   
  
</form>
<form action="{{ route('dataleads.export') }}" method="GET">
    <button type="submit" style ="float : right;"class="btn btn-success btn-sm mb-2">Export Data</button>
</form>

                        @include('components.alert')
                        </div>
                        <div class="card-body">


                        <div class="dataTables_length mb-3" id="myDataTable_length">
<label for="entries"> Show
<select id="entries" name="myDataTable_length" aria-controls="myDataTable"  onchange="changeEntries()" class>
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
entries
</label>
</div>

<div id="myDataTable_filter" class="dataTables_filter">
    <label for="search">Search
        <input id="search" placeholder>
    </label>
</div>

                            
                            <div class="table-responsive">
                          
                                <table  class="table table-bordered"  width="100%" cellspacing="0" style="border-radius: 10px;">
                                    <thead>
                                        <tr>
                                          <th>No</th>
                                          <th>Nama Customer</th>
                                          <th>PIC</th>
                                          <th>Status</th>
                                          <th>Tanggal Terima Form KBB</th>
                                          <th>Tanggal Terima Form KBB Payroll</th>
                                          <th>Jenis Data</th>
                                          <th>Tanggal Follow Up</th>
                                         
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                     @foreach ($dataleads as $dataleads)
                                    <tr>
                                      <td>{{$dataleads -> no}}</td>
                                  <td>{{$dataleads -> cust_name}}</td>
                                  <td>{{$dataleads -> nama_pic_kbb}}</td>
                                  <td>{{$dataleads -> status}}</td>
                                  <td>{{$dataleads -> tanggal_terima_form_kbb}}</td>
                                  <td>{{$dataleads -> tanggal_terima_form_kbb_payroll}}</td>
                                  <td>{{$dataleads -> jenis_data}}</td>
                                  <td>{{$dataleads -> tanggal_follow_up}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                <div class="dataTables_info" id="dataTableInfo" role="status" aria-live="polite">
    Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalEntries">0</span> entries
</div>
        
<div class="dataTables_paginate paging_simple_numbers" id="myDataTable_paginate">
    
    <a href="#" class="paginate_button" id="doublePrevButton" onclick="doublePreviousPage()"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
    <a href="#" class="paginate_button" id="prevButton" onclick="previousPage()"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    <span>
        <a id="pageNumbers" aria-controls="myDataTable" role="link" aria-current="page" data-dt-idx="0" tabindex="0"></a>
    </span>
    <a href="#" class="paginate_button" id="nextButton" onclick="nextPage()"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
    <a href="#" class="paginate_button" id="doubleNextButton" onclick="doubleNextPage()"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
</div>
                              
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
           
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    
    <style>
  .actions-container {
    display: flex;
    align-items: center; /* Optional: Align items vertically centered */
  }

  .muted {
    pointer-events: none; /* Disable click events */
    opacity: 0.5; /* Add transparency to indicate it's muted */
  }


</style>


<script>
    var itemsPerPage = 10; // Ubah nilai ini sesuai dengan jumlah item per halaman
    var currentPage = 1;
    var filteredData = [];
    
    function initializeData() {
    var tableRows = document.querySelectorAll("table tbody tr");
    filteredData = Array.from(tableRows); // Konversi NodeList ke array
    updatePagination();
}

// Panggil fungsi initializeData() untuk menginisialisasi data saat halaman dimuat
initializeData();
    
function doublePreviousPage() {
        if (currentPage > 1) {
            currentPage = 1;
            updatePagination();
        }
    }
    
function nextPage() {
    var totalPages = Math.ceil(document.querySelectorAll("table tbody tr").length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
    }
}
  
function doubleNextPage() {
    var totalPages = Math.ceil(document.querySelectorAll("table tbody tr").length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage = totalPages;
        updatePagination();
    }
}

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }
 
    function updatePagination() {
    var startIndex = (currentPage - 1) * itemsPerPage;
    var endIndex = startIndex + itemsPerPage;

    // Sembunyikan semua baris
    var tableRows = document.querySelectorAll("table tbody tr");
    tableRows.forEach(function (row) {
        row.style.display = 'none';
    });

    // Tampilkan baris untuk halaman saat ini
    for (var i = startIndex; i < endIndex && i < filteredData.length; i++) {
        filteredData[i].style.display = 'table-row';
    }

    // Update nomor halaman
    var totalPages = Math.ceil(filteredData.length / itemsPerPage);
    var pageNumbers = document.getElementById('pageNumbers');
    pageNumbers.innerHTML = '';

    var totalEntries = filteredData.length;

    document.getElementById('showingStart').textContent = startIndex + 1;
    document.getElementById('showingEnd').textContent = Math.min(endIndex, totalEntries);
    document.getElementById('totalEntries').textContent = totalEntries;

    var pageRange = 3; // Jumlah nomor halaman yang ditampilkan
    var startPage = Math.max(1, currentPage - Math.floor(pageRange / 2));
    var endPage = Math.min(totalPages, startPage + pageRange - 1);

    for (var i = startPage; i <= endPage; i++) {
        var pageButton = document.createElement('button');
        pageButton.className = 'btn btn-primary btn-sm mr-1 ml-1';
        pageButton.textContent = i;
        if (i === currentPage) {
            pageButton.classList.add('btn-active');
        }
        pageButton.onclick = function () {
            currentPage = parseInt(this.textContent);
            updatePagination();
        };
        pageNumbers.appendChild(pageButton);
    }
}
    function changeEntries() {
        var entriesSelect = document.getElementById('entries');
        var selectedEntries = parseInt(entriesSelect.value);

        // Update the 'itemsPerPage' variable with the selected number of entries
        itemsPerPage = selectedEntries;

        // Reset the current page to 1 when changing the number of entries
        currentPage = 1;

        // Update pagination based on the new number of entries
        updatePagination();
    }

    function applySearchFilter() {
    var searchInput = document.getElementById('search');
    var filter = searchInput.value.toLowerCase();
    
    // Mencari data yang sesuai dengan filter
    filteredData = Array.from(document.querySelectorAll("table tbody tr")).filter(function (row) {
        var rowText = row.textContent.toLowerCase();
        return rowText.includes(filter);
    });

    // Set currentPage kembali ke 1
    currentPage = 1;

    updatePagination();
}

updatePagination();



    // Menangani perubahan pada input pencarian
    document.getElementById('search').addEventListener('input', applySearchFilter);
    // Panggil updatePagination untuk inisialisasi
  
             
</script>

<style>
    
    
.dataTables_paginate{float:right;text-align:right;padding-top:.25em}
.paginate_button {box-sizing:border-box;
    display:inline-block;
    min-width:1.5em;
    padding:.5em 1em;
    margin-left:2px;
    text-align:center;
    text-decoration:none !important;
    cursor:pointer;color:inherit !important;
    border:1px solid transparent;
    border-radius:2px;
    background:transparent}

.dataTables_length{float:left}.dataTables_wrapper .dataTables_length select{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;padding:4px}
.dataTables_info{clear:both;float:left;padding-top:.755em}    
.dataTables_filter{float:right;text-align:right}
.dataTables_filter input{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;margin-left:3px}
</style>


<script>

function validateForm() {
    let tanggal_awal = document.forms["saveform"]["tanggal_awal"].value;
    let tanggal_akhir = document.forms ["saveform"]["tanggal_akhir"].value;
    let file = document.forms["saveform"]["file"].value;

    if (tanggal_awal == ""){
        alert("Tanggal Awal tidak boleh kosong");
        return false;
    }

    else if (tanggal_akhir == ""){
        alert("Tanggal Akhir tidak boleh kosong");
        return false;
    }

    else if (file == ""){
        alert("File tidak boleh kosong");
        return false;
    }
}
</script>
   @endsection