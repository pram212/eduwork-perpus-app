@extends('layouts.app')

@section("content-header", "Peminjaman")
@section("title", "Peminjaman")
@section('subtitle', 'Tambah Peminjaman')
@section('content-title', 'Tambah Peminjaman' )

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title">Edit Peminjaman</h4>
            </div>
            <div class="card-body">
                <form action="{{route('transaction.update', $transaction )}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                      <label for="member_id" class="form-label">Peminjam</label>
                      <select class="form-control @error('member_id') is-invalid @enderror" name="member_id" id="member_id">
                          <option value="">--Pilih--</option>
                          @foreach ($members as $member)
                          <option value="{{$member->id}}" @if ($transaction->member_id == $member->id)
                              selected
                          @endif>{{$member->name}}</option>
                          @endforeach
                      </select>
                      @error('member_id')
                          <small class="text-danger">{{$message}}</small>
                      @enderror
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label>Tanggal</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input type="date" name="start" id="start" class="form-control" value="{{$transaction->start}}">
                            </div>
                            @error('start')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-1 text-center">
                            <span><b>s/d</b></span>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input type="date" name="end" id="end" class="form-control" value="{{$transaction->end}}">
                            </div>
                            @error('end')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Buku</label>
                        <select class="select2" multiple="multiple" data-placeholder="Masukan Buku" style="width: 100%;" name="book_id[]" id="select-books">
                            @foreach ($buku as $b)
                                <option value="{{$b->id}}" class="option-books" {{ select_m2m($b->id, 'book_id', $transaction, $transaction->books->pluck('id')) }}>
                                    {{$b->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <!-- radio -->
                    <div class="form-group clearfix">
                        <div class="icheck-success d-inline">
                          <input type="radio" @if ($transaction->status) checked @endif name="status" id="done" value="1">
                          <label for="done">Sudah dikembalikan</label>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="icheck-danger d-inline">
                          <input type="radio" @if (!$transaction->status) checked @endif name="status" id="proccess" value="0">
                          <label for="proccess">Belum dikembalikan</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Ubah</button>
                        <a href="{{route('transaction.index')}}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{asset('vendor/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('vendor/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{asset('vendor/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
<!-- BS Stepper -->
<link rel="stylesheet" href="{{asset('vendor/plugins/bs-stepper/css/bs-stepper.min.css')}}">
<!-- dropzonejs -->
<link rel="stylesheet" href="{{asset('vendor/plugins/dropzone/min/dropzone.min.css')}}">

@endsection

@push('script')
<!-- Select2 -->
<script src="{{asset('vendor/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('vendor/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('vendor/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('vendor/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('vendor/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- BS-Stepper -->
<script src="{{asset('vendor/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<!-- dropzonejs -->
<script src="{{asset('vendor/plugins/dropzone/min/dropzone.min.js')}}"></script>

<!-- Page specific script -->
<script>
  $(function () {
    // document.getElementById("start").value = "12/12/2021";
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
@endpush
