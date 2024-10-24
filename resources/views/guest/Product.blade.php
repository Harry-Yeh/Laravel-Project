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

        <button class="lg:hidden w-10 h-10 ml-auto flex items-center justify-center border border-blue-500 text-blue-500 rounded-md" @click="navbarOpen = !navbarOpen">
            <i data-feather="menu"></i>
        </button>
    </div>

   
    
    
    @auth
    <ul class="lg:flex flex-col lg:flex-row lg:items-center lg:mx-auto lg:space-x-8 xl:space-x-14" :class="{'hidden':!navbarOpen,'flex':navbarOpen}">
    <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
            <a href="/">首頁</a>
        </li>
        <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
            <a href="/products">商品</a>
        </li>
        <!-- <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
            <a href="/products-create">刊登</a>
        </li>
        <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
            <a href="/products-check">我的商品</a>
        </li>   -->
    </ul>
    @else
    <ul class="lg:flex flex-col lg:flex-row lg:items-center lg:mx-auto lg:space-x-8 xl:space-x-14" :class="{'hidden':!navbarOpen,'flex':navbarOpen}">
        <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
            <a href="/">首頁</a>
        </li>
        <li class="font-semibold text-gray-900 hover:text-gray-400 transition ease-in-out duration-300 mb-5 lg:mb-0 text-2xl">
            <a href="/products">商品</a>
        </li>
    </ul>
    @endauth

    <div class="lg:flex flex-col md:flex-row md:items-center text-center md:space-x-6" :class="{'hidden':!navbarOpen,'flex':navbarOpen}">
        @auth
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-3xl leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <img width="65" height="65" src="images/account.png" alt="">    
                        <div>{{ Auth::user()->name }}</div>

                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.partials.control')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <x-dropdown-link :href="route('products.create')">
                    {{ __('使用者後台') }}
                </x-dropdown-link>

                <x-dropdown-link :href="route('admin.message')">
                    {{ __('管理者後台') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
        @else
        <a href="/register" class="px-6 py-4 bg-blue-500 text-white font-semibold text-lg rounded-xl hover:bg-blue-700 transition ease-in-out duration-500 mb-5 md:mb-0">註冊</a>
        <a href="/login" class="px-6 py-4 border-2 border-blue-500 text-blue-500 font-semibold text-lg rounded-xl hover:bg-blue-700 hover:text-white transition ease-linear duration-500">登入</a>
        @endauth
        </div>
    </nav>
            <!-- </div>
            </section> -->
            <!-- 新增：搜索表單 -->
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <div class="flex items-center justify-center gap-2">
                <input type="text" name="search" placeholder="搜索產品名稱..." value="{{ $search ?? '' }}" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">搜索</button>
            </div>
    
    <!-- 保留現有的標籤選擇 -->
                @foreach($tagSlugs as $tagSlug)
                <input type="hidden" name="tags[]" value="{{ $tagSlug }}">
                @endforeach
            </form>
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-2 justify-center">
                <select id="subject" name="tags[]" class="bg-gray text-primary-foreground px-4 py-2 rounded-md">
                    <option value="">選擇科目...</option>
                    @foreach($allTags as $tag)
                        @if($tag->type === '科目')
                            <option value="{{ $tag->getTranslation('slug', 'zh') }}" {{ in_array($tag->getTranslation('slug', 'zh'), $tagSlugs) ? 'selected' : '' }}>
                                {{ $tag->getTranslation('name', 'zh') }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <select id="category" name="tags[]" class="bg-gray text-primary-foreground px-4 py-2 rounded-md">
                    <option value="">選擇課程...</option>
                    @foreach($allTags as $tag)
                        @if($tag->type === '課程')
                            <option value="{{ $tag->getTranslation('slug', 'zh') }}" {{ in_array($tag->getTranslation('slug', 'zh'), $tagSlugs) ? 'selected' : '' }}>
                                {{ $tag->getTranslation('name', 'zh') }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <select id="grade" name="tags[]" class="bg-gray text-primary-foreground px-4 py-2 rounded-md">
                    <option value="">選擇年級...</option>
                    @foreach($allTags as $tag)
                        @if($tag->type === '年級')
                            <option value="{{ $tag->getTranslation('slug', 'zh') }}" {{ in_array($tag->getTranslation('slug', 'zh'), $tagSlugs) ? 'selected' : '' }}>
                                {{ $tag->getTranslation('name', 'zh') }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <select id="semester" name="tags[]" class="bg-gray text-primary-foreground px-4 py-2 rounded-md">
                    <option value="">選擇學期...</option>
                    @foreach($allTags as $tag)
                        @if($tag->type === '學期')
                            <option value="{{ $tag->getTranslation('slug', 'zh') }}" {{ in_array($tag->getTranslation('slug', 'zh'), $tagSlugs) ? 'selected' : '' }}>
                                {{ $tag->getTranslation('name', 'zh') }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition ease-in-out duration-300">
                    搜索
                </button>
            </form>
            

            <div class="flex flex-col w-full min-h-screen">
                <main class="flex min-h-[calc(100vh_-_theme(spacing.16))] flex-1 flex-col gap-4 p-4 md:gap-8 md:p-10">
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($products as $product)
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                                <div class="space-y-1.5 p-6">
                                    <h4 class="font-semibold text-2xl mb-2">商品名稱:{{$product->name}}</h4>
                                    <div><h1 class="font-semibold">用戶名稱:{{ $product->user->name }}</h1></div>
                                </div>
                                <div class="p-6">
                                    <div class="text-2xl font-bold">${{$product->price}}</div>
                                    <h1 class="font-semibold">上架時間: {{$product->updated_at->format('Y/m/d')}}</h1>
                                    <p class="font-semibold text-sm mt-2">{{$product->description}}</p>
                                    <div class="mt-4">
                                        @if($product->media->isNotEmpty())
                                            @php
                                                $media = $product->getFirstMedia('images');
                                            @endphp
                                            @if($media)
                                                <img src="{{ $media->getUrl()}}" alt="這是圖片" width="1200" height="900" style="aspect-ratio: 900 / 1200; object-fit: cover;" class="w-full rounded-md object-cover" />
                                            @else
                                            <div>沒圖片</div>
                                            @endif
                                        @else
                                            <div>沒有圖片</div>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between mb-8">
                                        <h6 class="font-black text-gray-600 text-sm md:text-lg">年級 : 
                                            <span class="font-semibold text-gray-900 text-md md:text-lg">
                                            @php
                                                $gradeTag = $product->tags->firstWhere('type', '年級');
                                                $semesterTag = $product->tags->firstWhere('type', '學期');
                                            @endphp
                                            {{ $gradeTag ? $gradeTag->getTranslation('name', 'zh') : '無' }}
                                            {{ $semesterTag ? $semesterTag->getTranslation('name', 'zh') : '學期:無' }}
                                            </span>
                                        </h6>
                                        <h6 class="font-black text-gray-600 text-sm md:text-lg">課程 : 
                                            <span class="font-semibold text-gray-900 text-md md:text-lg">
                                                @php
                                                    $categoryTag = $product->tags->firstWhere('type', '課程');
                                                @endphp
                                                {{ $categoryTag ? $categoryTag->getTranslation('name', 'zh') : '無' }}
                                            </span>
                                        </h6>
                                 </div>
                                </div>
                                <div class="flex items-center p-6">
                                <a href= "{{ route('products.chirps.index', ['product' => $product->id]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-xl 
                                        text-lg font-semibold ring-offset-background 
                                        transition-colors ease-in-out duration-500 focus-visible:outline-none 
                                        focus-visible:ring-2 focus-visible:ring-ring 
                                        focus-visible:ring-offset-2 disabled:pointer-events-none 
                                        disabled:opacity-50 bg-blue-500 text-white hover:bg-blue-700 h-10 px-3 py-2 ml-auto">
                                    洽談
                                </a>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        
                    <div class="mt-6">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </main>
            </div>
</body>
</html>