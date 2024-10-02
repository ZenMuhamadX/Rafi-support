<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" /> 
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">      
        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <!-- Main CSS File -->
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/materi.css') }}">
        <style>
            .custom-card {
                cursor: pointer;
                transition: transform 0.3s;
            }
            .custom-card:hover {
                transform: scale(1.02);
            }
        </style>
    </head>
    <body>
        <!-- Include header -->
        @include('component.header-user')

        <!-- Section untuk konten -->
        <br><br><br><br><br>

        <!-- Materi Section -->
        <div class="container">
            <h1>Materi untuk bab :</h1>

            @if($submateri->submateri->isEmpty())
                <p>Tidak ada sub materi untuk materi ini.</p>
            @else
                <div class="row">
                    @foreach($submateri->submateri as $item)
                        <div class="col-md-6 mb-4">
                            <div class="custom-card border border-dark-subtle p-3" 
                                 data-type="{{ $item->type }}" 
                                 data-content="{{ $item->content }}" 
                                 onclick="handleCardClick(this)">
                                <h4>{{ $item->title }}</h4>
                                <p>{{ $item->type == 'text' ? Str::limit($item->content, 100) : '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Bootstrap core JS-->
        <script>
            function handleCardClick(element) {
                // Ambil data dari atribut data-*
                const type = element.getAttribute('data-type');
                const content = element.getAttribute('data-content');

                if (type === 'youtube') {
                    // Buka video YouTube
                    if (content.startsWith('http')) {
                        window.open(content, '_blank');
                    }
                } else if (type === 'pdf') {
                    // Unduh file PDF
                    if (content.endsWith('.pdf')) {
                        window.location.href = content;
                    }
                } else if (type === 'text') {
                    // Buka halaman baru atau modal untuk teks
                    const newWindow = window.open("", "_blank");
                    newWindow.document.write("<html><head><title>Materi Teks</title></head><body><p>" + content + "</p></body></html>");
                    newWindow.document.close();
                }
            }
        </script>
    </body>
</html>
