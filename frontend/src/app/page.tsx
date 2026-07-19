import Image from "next/image";

export default function Home() {
  return (
    <div className="font-sans min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
      {/* Mobile-first responsive container */}
      <div className="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <main className="max-w-4xl mx-auto">
          {/* Hero Section */}
          <div className="text-center mb-12 sm:mb-16">
            <div className="mb-8">
              <Image
                className="dark:invert mx-auto"
                src="/next.svg"
                alt="Next.js logo"
                width={200}
                height={42}
                priority
              />
            </div>
            
            <h1 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
              Selamat Datang di e-Kinerja
            </h1>
            <p className="text-lg sm:text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
              Sistem manajemen kinerja yang modern dan responsif untuk mengelola produktivitas tim Anda
            </p>
          </div>

          {/* Features Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
              <div className="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                <i className="fas fa-chart-line text-blue-600 dark:text-blue-400 text-xl"></i>
              </div>
              <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                Analisis Kinerja
              </h3>
              <p className="text-gray-600 dark:text-gray-300">
                Pantau dan analisis performa tim dengan dashboard yang intuitif
              </p>
            </div>

            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
              <div className="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                <i className="fas fa-users text-green-600 dark:text-green-400 text-xl"></i>
              </div>
              <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                Manajemen Tim
              </h3>
              <p className="text-gray-600 dark:text-gray-300">
                Kelola anggota tim dan delegasikan tugas dengan mudah
              </p>
            </div>

            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
              <div className="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                <i className="fas fa-mobile-alt text-purple-600 dark:text-purple-400 text-xl"></i>
              </div>
              <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                Mobile Responsive
              </h3>
              <p className="text-gray-600 dark:text-gray-300">
                Akses dari mana saja dengan tampilan yang optimal di semua perangkat
              </p>
            </div>
          </div>

          {/* Action Buttons */}
          <div className="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
            <a
              className="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition-colors flex items-center justify-center gap-2"
              href="/login"
            >
              <i className="fas fa-sign-in-alt"></i>
              Masuk ke Dashboard
            </a>
            <a
              className="w-full sm:w-auto border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium py-3 px-8 rounded-lg transition-colors flex items-center justify-center gap-2"
              href="/register"
            >
              <i className="fas fa-user-plus"></i>
              Daftar Sekarang
            </a>
          </div>

          {/* Quick Links */}
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a
              className="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
              href="/docs"
            >
              <Image
                aria-hidden
                src="/file.svg"
                alt="File icon"
                width={20}
                height={20}
                className="dark:invert"
              />
              <span className="text-gray-700 dark:text-gray-300">Dokumentasi</span>
            </a>
            <a
              className="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
              href="/examples"
            >
              <Image
                aria-hidden
                src="/window.svg"
                alt="Window icon"
                width={20}
                height={20}
                className="dark:invert"
              />
              <span className="text-gray-700 dark:text-gray-300">Contoh</span>
            </a>
            <a
              className="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors sm:col-span-2 lg:col-span-1"
              href="/about"
            >
              <Image
                aria-hidden
                src="/globe.svg"
                alt="Globe icon"
                width={20}
                height={20}
                className="dark:invert"
              />
              <span className="text-gray-700 dark:text-gray-300">Tentang Kami</span>
            </a>
          </div>
        </main>
      </div>
    </div>
  );
}
