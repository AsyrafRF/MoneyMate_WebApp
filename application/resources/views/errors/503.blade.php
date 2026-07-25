<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8" />
  <title>Maintenance | MoneyMate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
</head>

<body class="bg-slate-100 dark:bg-slate-900 flex items-center justify-center min-h-screen px-4">

  <div class="bg-white dark:bg-slate-800 shadow-xl rounded-2xl p-8 max-w-md w-full text-center">

    <!-- Logo -->
    <img src="{{ asset('images/moneymate-original.png') }}" 
         alt="Company Logo"
         class="mx-auto h-14 mb-4" />

    <!-- Spinner -->
    <div class="flex justify-center mb-4">
      <div class="h-6 w-6 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- ID -->
    <div id="id">
      <h1 class="text-2xl font-semibold text-slate-800 dark:text-white mb-2">
        Pemeliharaan Sistem
      </h1>
      <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
        Mohon maaf atas ketidaknyamanan yang terjadi.<br>
        Sistem <b>MoneyMate</b> saat ini sedang mengalami gangguan
        atau dalam proses pemeliharaan terjadwal.<br><br>
        Tim kami sedang melakukan penanganan agar layanan
        dapat kembali beroperasi secara normal sesegera mungkin.
      </p>
    </div>

    <!-- EN -->
    <div id="en" class="hidden">
      <h1 class="text-2xl font-semibold text-slate-800 dark:text-white mb-2">
        System Maintenance
      </h1>
      <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
        We apologize for the inconvenience.<br>
        <b>MoneyMate</b> is currently undergoing maintenance
        or experiencing a temporary service disruption.<br><br>
        Our team is actively working to restore full service
        as soon as possible.
      </p>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex flex-col gap-3">
      <a href="https://www.instagram.com/moneymate_id"
         target="_blank"
         class="bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium">
        📞 Hubungi Support (Instagram)
      </a>

      <a href="https://stats.uptimerobot.com/Q3ImLiNYVP" 
        target="_blank"
        id="status-link"
        class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 
                text-slate-800 dark:text-white py-2 rounded-lg font-medium transition-colors">
        📊 Status Layanan
      </a>
    </div>

    <!-- Language Switch -->
    <div class="mt-6 text-sm text-slate-500 dark:text-slate-400">
      <button onclick="switchLang('id')" class="hover:underline">ID</button> |
      <button onclick="switchLang('en')" class="hover:underline">EN</button>
    </div>

    <p class="mt-4 text-xs text-slate-400">
      © 2025 @if(date('Y') > 2025)- {{ date('Y') }} @endif MoneyMate ID. All rights reserved.
    </p>
  </div>

  <script>
    function switchLang(lang) {
      // Sembunyikan semua teks deskripsi
      document.getElementById('id').classList.add('hidden');
      document.getElementById('en').classList.add('hidden');
      
      // Tampilkan teks yang dipilih
      document.getElementById(lang).classList.remove('hidden');
      
      // Update teks pada tombol Status Layanan
      const statusBtn = document.getElementById('status-link');
      if (lang === 'id') {
        statusBtn.innerHTML = '📊 Status Layanan';
      } else {
        statusBtn.innerHTML = '📊 Service Status';
      }
      
      // Ganti atribut lang pada HTML
      document.documentElement.lang = lang;
    }
  </script>

</body>
</html>
