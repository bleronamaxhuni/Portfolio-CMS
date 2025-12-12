<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f0f4ff] text-gray-800 font-sans">

    <!-- HEADER -->
    <header class="fixed top-0 left-0 w-full bg-white shadow z-50">
        <nav class="max-w-6xl mx-auto flex justify-between items-center p-4">
            <div class="text-xl font-bold">Blerona</div>
            <ul class="flex gap-6">
                <li><a href="#experiences" class="text-gray-700 hover:text-blue-600 transition-colors duration-300">Experiences</a></li>
                <li><a href="#skills" class="text-gray-700 hover:text-blue-600 transition-colors duration-300">Skills</a></li>
                <li><a href="#projects" class="text-gray-700 hover:text-blue-600 transition-colors duration-300">Projects</a></li>
                <li><a href="#contact" class="text-gray-700 hover:text-blue-600 transition-colors duration-300">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- ABOUT ME -->
    <section class="min-h-screen flex items-center bg-[#f0f4ff] px-6 md:px-20 pt-24">
        <div class="flex flex-col md:flex-row items-center gap-16 w-full">

            <!-- LEFT TEXT -->
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-semibold text-blue-700 flex items-center justify-center md:justify-start gap-2">
                    Hi, I’m {{ $about->name ?? 'Blerona' }}
                    <span class="animate-wave inline-block">👋</span>
                </h2>

                <h1 class="mt-4 text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                    Full-Stack <br> Developer
                </h1>

                <p class="mt-6 text-lg text-gray-700 max-w-md mx-auto md:mx-0">
                    {{ $about->bio ?? 'I develop user-friendly interfaces with a focus on usability and performance.' }}
                </p>

                <!-- Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                    <a href="#contact"
                    class="bg-blue-600 text-white px-8 py-3 rounded-xl font-medium shadow-lg hover:bg-blue-700 transition-all duration-300 hover:shadow-xl">
                        Get in touch
                    </a>

                    <a href="{{ asset('storage/Blerona_CV.pdf') }}" download
                    class="bg-gray-200 text-gray-800 px-8 py-3 rounded-xl font-medium shadow-lg hover:bg-gray-300 transition-all duration-300 hover:shadow-xl">
                        Download Resume
                    </a>
                </div>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="flex-1 flex justify-center">
                <div class="w-64 h-64 md:w-80 md:h-80 rounded-full overflow-hidden bg-white shadow-2xl flex items-center justify-center transform transition-transform hover:scale-105 duration-700 ease-in-out">
                    @if(!empty($about->profile_image))
                        <img src="{{ asset('storage/' . $about->profile_image) }}" 
                            alt="Profile photo"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image Available
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    <!-- EXPERIENCES -->
    <section id="experiences" class="py-16 bg-gray-50">
        <h2 class="text-3xl font-semibold mb-10 text-center text-gray-900">Experiences</h2>
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
            @foreach($experiences as $exp)
                <div class="p-6 bg-white rounded-2xl shadow-md transform hover:-translate-y-2 hover:shadow-xl transition-all duration-700 ease-in-out">
                    <h3 class="font-bold text-xl mb-1">{{ $exp->title }}</h3>
                    <p class="text-blue-600 font-medium">{{ $exp->company }}</p>
                    <p class="mt-3 text-gray-600">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- SKILLS -->
    <section id="skills" class="py-16">
        <h2 class="text-3xl font-semibold mb-10 text-center text-gray-900">Skills</h2>
        <div class="max-w-5xl mx-auto flex flex-wrap justify-center gap-4">
            @foreach($skills as $skill)
                <span class="px-5 py-2 bg-blue-100 text-blue-800 rounded-full font-medium shadow-sm transform hover:scale-110 hover:bg-blue-200 transition-all duration-500 ease-in-out">
                    {{ $skill->name }}
                </span>
            @endforeach
        </div>
    </section>

    <!-- PROJECTS -->
    <section id="projects" class="py-16 bg-gray-50">
        <h2 class="text-3xl font-semibold mb-10 text-center text-gray-900">Projects</h2>
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <div class="p-6 bg-white rounded-2xl shadow-md transform hover:-translate-y-2 hover:shadow-xl transition-all duration-700 ease-in-out">
                    <h3 class="font-bold text-xl">{{ $project->title }}</h3>
                    <p class="mt-3 text-gray-700">{{ $project->description }}</p>
                    @if($project->link)
                        <a href="{{ $project->link }}" class="text-blue-600 mt-4 inline-block hover:underline">View Project</a>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="py-16">
        <h2 class="text-3xl font-semibold mb-10 text-center text-gray-900">Contact Me</h2>
        <form action="" method="POST" class="max-w-2xl mx-auto flex flex-col gap-4">
            @csrf
            <input type="text" name="name" placeholder="Your Name" class="p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all duration-200">
            <input type="email" name="email" placeholder="Your Email" class="p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all duration-200">
            <textarea name="message" rows="5" placeholder="Your Message" class="p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all duration-200"></textarea>
            <button type="submit" class="bg-blue-600 text-white py-4 rounded-xl shadow-lg hover:bg-blue-700 transition-all duration-300">Send</button>
        </form>
    </section>

    <style>
        .animate-wave {
            display: inline-block;
            transform-origin: 70% 70%;
            animation: wave 2s infinite;
        }
        @keyframes wave {
            0% { transform: rotate(0deg); }
            15% { transform: rotate(14deg); }
            30% { transform: rotate(-8deg); }
            45% { transform: rotate(14deg); }
            60% { transform: rotate(-4deg); }
            75% { transform: rotate(10deg); }
            100% { transform: rotate(0deg); }
        }
        html {
            scroll-behavior: smooth;
        }
    </style>

</body>
</html>
