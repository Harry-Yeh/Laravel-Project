<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="images/icon.png">
        <title>聯大二手書交易平台</title>
        <link rel="stylesheet" href="css/tailwind.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" integrity="sha512-7x3zila4t2qNycrtZ31HO0NnJr8kg2VI67YLoRSyi9hGhRN66FHYWr7Axa9Y1J9tGYHVBPqIjSE1ogHrJTz51g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> 
    </head>

    <body class="font-body">

        <!-- home section -->
        <section class="bg-white py-10 md:mb-10">

            <div class="container max-w-screen-xl mx-auto px-4">

                <nav class="flex-wrap lg:flex items-center" x-data="{navbarOpen:false}">
                    <div class="flex items-center mb-10 lg:mb-0">
                        <img src="images/book-4-fix.png" alt="Logo">

                        <!-- <button class="lg:hidden w-10 h-10 ml-auto flex items-center justify-center border border-blue-500 text-blue-500 rounded-md" @click="navbarOpen = !navbarOpen"> -->
                            <i data-feather="menu"></i>
                            <button class="lg:hidden w-10 h-10 ml-auto flex items-center justify-center border border-blue-500 text-blue-500 rounded-md" @click="navbarOpen = !navbarOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                        </button>
                        <!-- </button> -->
                    </div>

                    <ul class="lg:flex flex-col lg:flex-row lg:items-center lg:mx-auto lg:space-x-8 xl:space-x-14" :class="{'hidden':!navbarOpen,'flex':navbarOpen}">
                        <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
                            <a href="/">首頁</a>
                        </li>
                        <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
                            <a href="/product">商品</a>
                        </li>
                        <!-- <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
                            <a href="/add">刊登</a>
                        </li>
                        <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
                            <a href="/check">我的商品</a>
                        </li> -->
                    </ul>

                    <div class="lg:flex flex-col md:flex-row md:items-center text-center md:space-x-6" :class="{'hidden':!navbarOpen,'flex':navbarOpen}">
                        <a href="/register" class="px-6 py-4 bg-blue-500 text-white font-semibold text-lg rounded-xl hover:bg-blue-700 transition ease-in-out duration-500 mb-5 md:mb-0">註冊</a>

                        <a href="/login" class="px-6 py-4 border-2 border-blue-500 text-blue-500 font-semibold text-lg rounded-xl hover:bg-blue-700 hover:text-white transition ease-linear duration-500">登入</a>
                    </div>
                </nav>

                <style>:root{--background:0 0% 100%;--foreground:240 10% 3.9%;--card:0 0% 100%;--card-foreground:240 10% 3.9%;--popover:0 0% 100%;--popover-foreground:240 10% 3.9%;--primary:240 5.9% 10%;--primary-foreground:0 0% 98%;--secondary:240 4.8% 95.9%;--secondary-foreground:240 5.9% 10%;--muted:240 4.8% 95.9%;--muted-foreground:240 3.8% 45%;--accent:240 4.8% 95.9%;--accent-foreground:240 5.9% 10%;--destructive:0 72% 51%;--destructive-foreground:0 0% 98%;--border:240 5.9% 90%;--input:240 5.9% 90%;--ring:240 5.9% 10%;--chart-1:173 58% 39%;--chart-2:12 76% 61%;--chart-3:197 37% 24%;--chart-4:43 74% 66%;--chart-5:27 87% 67%;--radius:0.5rem;}img[src="/placeholder.svg"],img[src="/placeholder-user.jpg"]{filter:sepia(.3) hue-rotate(-60deg) saturate(.5) opacity(0.8) }</style>
<style>h1, h2, h3, h4, h5, h6 { font-family: 'Inter', sans-serif; --font-sans-serif: 'Inter'; }
</style>
<style>body { font-family: 'Inter', sans-serif; --font-sans-serif: 'Inter'; }
</style>

<div class="flex flex-col w-full min-h-screen">
  <main class="flex min-h-[calc(100vh_-_theme(spacing.16))] flex-1 flex-col gap-4 p-4 md:gap-8 md:p-10">
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2">
          <h1>商品名稱:會計學</h1>
          <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
            <img class="aspect-square h-full w-full" alt="上架者" src="images/user.png" />
          </span>
        </div>
        <div class="p-6">
          <div class="text-2xl font-bold">$500</div>
          <h1>上架時間: 2023/8/25</h1>
          <p class="text-sm mt-2">這是大一必修的會計學課本</p>
          <div class="mt-4">
            <img
              src="images/book-2.jpg"
              alt="這是圖片"
              width="1200"
              height="900"
              style="aspect-ratio: 900 / 1200; object-fit: cover;"
              class="w-full rounded-md object-cover"
            />
            <p>這是會計學</p>
          </div>
        </div>
        <div class="flex items-center p-6">
          <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 ml-auto">
            購買
          </button>
        </div>
      </div>
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2">
        <h1>商品名稱:統計學</h1>
          <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
            <img class="aspect-square h-full w-full" alt="上架者" src="images/user.png" />
          </span>
        </div>
        <div class="p-6">
          <div class="text-2xl font-bold">$600</div>
          <h1>上架時間: 2023/8/24</h1>
          <p class="text-sm mt-2">這是大二必修的統計學課本</p>
          <div class="mt-4">
            <img
              src="images/book-1.jpg"
              alt=""
              width="1200"
              height="900"
              class="w-full rounded-md object-cover"
              style="aspect-ratio: 900 / 1200; object-fit: cover;"
            />
            <p class="text-sm text-muted-foreground mt-1">這是統計學</p>
          </div>
        </div>
        <div class="flex items-center p-6">
          <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 ml-auto">
            購買
          </button>
        </div>
      </div>
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2">
        <h1>商品名稱:範例</h1>
          <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
            <img class="aspect-square h-full w-full" alt="上架者" src="images/user.png" />
          </span>
        </div>
        <div class="p-6">
          <div class="text-2xl font-bold">$1800</div>
          <h1>上架時間: 2023/8/21</h1>
          <p class="text-sm mt-2">介紹範例</p>
          <div class="mt-4">
            <img
              src="images/book-3.jpg"
              alt=""
              width="1200"
              height="900"
              class="w-full rounded-md object-cover"
              style="aspect-ratio: 900 / 1200; object-fit: cover;"
            />
            <p class="text-sm text-muted-foreground mt-1">圖片範例</p>
          </div>
        </div>
        <div class="flex items-center p-6">
          <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 ml-auto">
            購買
          </button>
        </div>
      </div>
      
  </main>
</div>

    </body>
</html>