<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Register a Visitor</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Register of Visitor
        </h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 text-center rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('visitor.store') }}" class="space-y-4">
            @csrf

            <!-- Nombre -->
            <div class="my-5">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full mt-1 p-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">

                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Documento -->
            <div class="my-5">
                <label class="block text-sm font-medium text-gray-700">Identification number</label>
                <input type="text" name="identification_number" value="{{ old('identification_number') }}"
                    class="w-full mt-1 p-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">

                @error('identification_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg cursor-pointer hover:bg-blue-700 transition">
                Register
            </button>
        </form>

        <!-- Volver al login -->
        <div class="text-center mt-4">
            <a href="/admin/login" class="text-sm text-blue-500 hover:underline">
                Back to the Login
            </a>
        </div>

    </div>

</body>

</html>
