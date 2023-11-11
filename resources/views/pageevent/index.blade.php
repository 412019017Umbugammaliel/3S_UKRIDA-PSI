@extends('layouts.app')

@section('title', 'UKRIDA 3S - Page Event')
    
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title">Data Event UKRIDA 3S</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahEventModal">Tambah Event</button>
                            </div>
                            @if (session()->has('success'))
                                <script>
                                    Swal.fire({
                                        title: 'Success',
                                        text: "{{ session('success') }}",
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                </script>
                            @endif
                        </div>
                    </div>                
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($event->count() > 0)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Event Date</th>
                                        <th>Session Type</th>
                                        <th>Availability</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $eventNumber = 1;
                                    @endphp
                                    @foreach ($event as $events)
                                    <tr>
                                        <td>{{ $eventNumber++ }}</td>
                                        <td>{{ $events->event_date }}</td>
                                        <td>{{ $events->session_type }}</td>
                                        <td>{{ $events->availability }}</td>
                                        <td>{{ $events->description }}</td>
                                        <td>
                                            <img src="{{ asset('images/' . $events->image_path) }}" alt="Image" style="max-width: 100px; max-height: 100px;">
                                        </td>     
                                        <td class="align-middle">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <div class="btn-group" role="group">
                                                    <button id="contentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="contentActions">
                                                        <a class="dropdown-item" href="#" onclick="showEventDetails('{{ $events->event_date }}', '{{ $events->session_type }}', '{{ $events->availability }}', '{{ $events->description }}', '{{ asset('images/' . $events->image_path) }}')">Details</a>
                                                        <a class="dropdown-item" href="#" onclick="showEditForm('{{ $events->id }}', '{{ $events->event_date }}', '{{ $events->session_type }}', '{{ $events->availability }}', '{{ $events->description }}', '{{ $events->image_path }}')">Edit</a>
                                                        <a class="dropdown-item" href="#" onclick="confirmDelete('{{ $events->id }}')">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-center">Event Tidak Ditemukan</p>
                            @endif
                        </div>
                    </div>                    
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <form action="{{ route('pageevent.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="event_date">Event Date:</label>
                            <input type="date" name="event_date" id="event_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="session_type">Session Type</label>
                            <select name="session_type" id="session_type" class="form-control">
                                <option value="" disabled selected>Pilih Option</option>
                                <option value="3S in House">3S in House</option>
                                <option value="3S Goes To School/Church">3S Goes To School/Church</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="availability">Availability</label>
                            <select name="availability" id="availability" class="form-control">
                                <option value="" disabled selected>Pilih Option</option>
                                <option value="Open">Open</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image_path">Image:</label>
                            <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*" required>
                        </div>                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
<script>
    //details
    function showEventDetails(eventDate, sessionType, availability, description, imageUrl) {
        Swal.fire({
            title: 'Event Details', // Judul SweetAlert
            html: `
                <div class="swal-content-details">
                    <div class="swal-details-row">
                        <span class="swal-details-label">Event Date:</span>
                        <p>${eventDate}</p>
                    </div>
                    <div class="swal-details-row">
                        <span class="swal-details-label">Session Type:</span>
                        <p>${sessionType}</p>
                    </div>
                    <div class="swal-details-row">
                        <span class="swal-details-label">Availability:</span>
                        <p>${availability}</p>
                    </div>
                    <div class="swal-details-row">
                        <span class="swal-details-label">Description:</span>
                        <p>${description}</p>
                    </div>
                    <div class="swal-details-row">
                        <span class="swal-details-label">Image:</span>
                    </div>
                    <div class="swal-details-row">
                        <img src="${imageUrl}" alt="Event Image" style="max-width: 100px; max-height: 100px;">
                    </div>
                </div>
            `,
            confirmButtonText: 'Close'
        });
    }


    //edit
    function showEditForm(id, event_date, session_type, availability, description, image_path) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        Swal.fire({
            title: 'Edit Event',
            html: `
                <form id="editEventForm" method="POST" action="/pageevent/updateevent/${id}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="event_date">Event Date</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" value="${event_date}" required>
                    </div>

                    <div class="form-group">
                        <label for="session_type">Session Type</label>
                        <select class="form-control" id="session_type" name="session_type">
                            <option value="3S in House" ${session_type === '3S in House' ? 'selected' : ''}>3S in House</option>
                            <option value="3S Goes To School/Church" ${session_type === '3S Goes To School/Church' ? 'selected' : ''}>3S Goes To School/Church</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="availability">Availability</label>
                        <select class="form-control" id="availability" name="availability">
                            <option value="Open" ${availability === 'Open' ? 'selected' : ''}>Open</option>
                            <option value="Close" ${availability === 'Close' ? 'selected' : ''}>Close</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>${description}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image_path">Image</label>
                        <input type="file" class="form-control" id="image_path" name="image_path">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            focusConfirm: false,
            preConfirm: () => {
                const form = document.getElementById('editEventForm');
                const formData = new FormData(form);

                // Kirim permintaan PUT menggunakan AJAX
                $.ajax({
                    type: 'POST',
                    url: form.getAttribute('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success').then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Failed to update event', 'error');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        Swal.fire('Error', 'An error occurred while updating event', 'error');
                    }
                });
            }
        });
    }


    //delete
    function confirmDelete(eventId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Menggunakan Ajax untuk menghapus data
                $.ajax({
                    url: '/pageevent/' + eventId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Sukses', response.message, 'success').then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Gagal Menghapus data pengguna', 'error');
                        }
                    },
                });
            }
        });
    }
</script>
@include('sweetalert::alert')
@endsection