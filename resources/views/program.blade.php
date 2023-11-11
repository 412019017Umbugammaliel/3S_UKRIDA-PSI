<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UKRIDA</title>
    <link rel="icon" href="{{ asset('images/Logo_UKRIDA.png') }}">

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

     <!-- Add Bootstrap JS and jQuery (if needed) -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    
    <style>

        .company-name {
            font-family: 'Arial', sans-serif;
            font-size: 24px;
            font-weight: bold;
            color: #fff; /* Warna teks */
        }

        .slogan {
            font-family: 'Tahoma', sans-serif;
            font-size: 18px;
            color: #f0f0f0; 
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .company-logo {
            max-height: 50px;
            max-width: 50px;
            margin-right: 10px;
        }
        /* Stilisasi footer */
        footer {
            background-color: #343a40; /* Warna latar belakang footer */
            color: white; /* Warna teks footer */
            padding: 20px 0; /* Padding atas dan bawah footer */
        }
        /* Memastikan konten halaman penuh tinggi */
        html, body {
            height: 100%;
        }
        /* Menerapkan Flexbox untuk footer */
        body {
            display: flex;
            flex-direction: column;
        }
        /* Isi konten diantara header dan footer */
        .content {
            flex: 1;
        }
        body{
            background-color: antiquewhite
        }
        nav{
            background-color: rgb(133, 152, 152)
        }
        .activity-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            cursor: pointer;
            transition: transform 0.2s;
            background-color: beige
        }

        .activity-card:hover {
            transform: translateY(-5px);
        }

        .activity-card img {
            width: 100%; 
            height: auto;
        }
        .image-container {
            width: 100%; 
            height: 200px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

    </style>
</head>
<body class="antialiased">
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <a class="navbar-brand" href="{{ asset('/') }}">
            <img src="{{ asset('images/Logo_UKRIDA.png') }}" alt="Company Logo" class="company-logo">
            <span class="company-name">UKRIDA 3S</span>
            <span class="slogan"> | Sukses Setelah Sekolah</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->level === 'Admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('userlogin') }}">Dashboard</a>
                            </li>
                        @endif
                    @endauth
                @endif
        
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('program') }}">Program</a>
                </li>
        
                @if (Route::has('login'))
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            Logout
                            <i class="fas fa-sign-out-alt"></i> 
                        </a>
                    </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Log in</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>            
    </nav>


    <!-- Add a container for your activities -->
    <div class="container content">
        <div class="row">
            <!-- Activity 1 -->
            @foreach($events as $event)
            <div class="col-md-4">
                <div class="activity-card" onclick="showEventDetails({{ $event->id }})">
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
    
    
    <footer class="main-footer">
        <div class="container">
            <div class="float-right d-none d-sm-block">
                <b>Psychology</b> 2019
                <a href="https://www.instagram.com/kampusukrida" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.twitter.com/ukrida" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="mailto:william.gunawan@ukrida.ac.id "><i class="far fa-envelope"></i></a>
            </div>
            <strong>Copyright &copy; <a href="https://ukrida.ac.id">UKRIDA 20231</a>.</strong> All rights reserved.
        </div>
    </footer>

    <script>
        function showEventDetails(eventId) {
            // Ganti URL sesuai dengan rute yang sesuai di aplikasi Laravel Anda
            const apiUrl = `/program/${eventId}`;
        
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
    
</body>

</html>