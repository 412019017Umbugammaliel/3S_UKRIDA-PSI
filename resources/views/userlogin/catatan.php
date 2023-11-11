@extends('userlogin.layouts.app')

@section('title', 'UKRIDA 3S - Dashboard')

@section('contents')


<section class="content">
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                    <div class="col-12">
                        <img src="../../dist/img/prod-1.jpg" class="product-image" alt="Product Image">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                    <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua
                        butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p>

                    <div class="mt-4">
                        <div class="btn btn-primary btn-lg btn-flat">
                            <i class="fas fa-cart-plus fa-lg mr-2"></i>
                            Add to Cart
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>



<div class="container content">
    <div class="row">
        @foreach($events as $event)
        <div class="col-md-4">
            <!-- <div class="activity-card" onclick="showEventDetails({{ $event->id }})"> -->
            <div class="image-container">
                <img src="{{ asset('images/' . $event->image_path) }}" alt="Event Image">
            </div>
            <h3>{{ $event->session_type }}</h3>
            <p>{{ $event->event_date }}</p>
            <button class="btn btn-warning" onclick="showEventDetails">Click for more info</button>
        </div>
    </div>
    @endforeach
</div>
</div>
<script>
    function showEventDetails(eventId) {
        // Ganti URL sesuai dengan rute yang sesuai di aplikasi Laravel Anda
        const apiUrl = `/userlogin/${eventId}`;

        $.ajax({
            url: apiUrl,
            type: 'GET',
            success: function (data) {
                if (data) {
                    Swal.fire({
                        title: data.title,
                        html: `
                            <div class="swal-event-details">
                                <div class="swal-details-row">
                                    <span class="swal-details-label">Date:</span>
                                    <p>${data.event_date}</p>
                                </div>
                                <div class="swal-details-row">
                                    <span class="swal-details-label">Session Type:</span>
                                    <p>${data.session_type}</p>
                                </div>
                                <div class="swal-details-row">
                                    <span class="swal-details-label">Description:</span>
                                    <p>${data.description}</p>
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'Close'
                    });
                } else {
                    Swal.fire('Error', 'Failed to retrieve event details', 'error');
                }
            },
            error: function (error) {
                console.error(error);
                Swal.fire('Error', 'An error occurred while fetching event details', 'error');
            }
        });
    }
</script>
@endsection