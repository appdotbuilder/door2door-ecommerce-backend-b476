import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="🛒 FreshDoor - Door-to-Door Grocery Delivery">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 text-gray-800 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 dark:text-gray-100">
                {/* Header */}
                <header className="w-full border-b border-green-200 bg-white/80 backdrop-blur-sm dark:border-gray-700 dark:bg-gray-900/80">
                    <div className="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                        <div className="flex items-center space-x-2">
                            <div className="text-3xl">🛒</div>
                            <h1 className="text-xl font-bold text-green-600 dark:text-green-400">FreshDoor</h1>
                        </div>
                        <nav className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="rounded-lg bg-green-600 px-6 py-2 text-white shadow-lg hover:bg-green-700 transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <div className="flex gap-3">
                                    <Link
                                        href={route('login')}
                                        className="rounded-lg border border-green-600 px-6 py-2 text-green-600 hover:bg-green-50 transition-colors dark:border-green-400 dark:text-green-400 dark:hover:bg-green-900/20"
                                    >
                                        Login
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="rounded-lg bg-green-600 px-6 py-2 text-white shadow-lg hover:bg-green-700 transition-colors"
                                    >
                                        Sign Up
                                    </Link>
                                </div>
                            )}
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <main className="flex-1">
                    <section className="mx-auto max-w-7xl px-6 py-20">
                        <div className="text-center">
                            <div className="mb-8 text-6xl">🚪🛍️</div>
                            <h1 className="mb-6 text-5xl font-bold leading-tight">
                                <span className="text-green-600">Fresh Groceries</span><br />
                                <span className="text-gray-800 dark:text-gray-100">Delivered to Your Door</span>
                            </h1>
                            <p className="mx-auto mb-12 max-w-2xl text-xl text-gray-600 dark:text-gray-300">
                                🏠 Monthly household essentials delivered fresh to your doorstep. 
                                From groceries to daily necessities, we've got you covered with convenient door-to-door service.
                            </p>
                            
                            {!auth.user && (
                                <div className="mb-16 flex justify-center gap-4">
                                    <Link
                                        href={route('register')}
                                        className="rounded-xl bg-green-600 px-8 py-4 text-lg font-semibold text-white shadow-xl hover:bg-green-700 transform hover:scale-105 transition-all duration-200"
                                    >
                                        🚀 Start Shopping Now
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="rounded-xl border-2 border-green-600 px-8 py-4 text-lg font-semibold text-green-600 hover:bg-green-50 transition-colors dark:border-green-400 dark:text-green-400 dark:hover:bg-green-900/20"
                                    >
                                        🔐 Login
                                    </Link>
                                </div>
                            )}
                        </div>
                    </section>

                    {/* Features Section */}
                    <section className="bg-white/50 py-20 dark:bg-gray-800/30">
                        <div className="mx-auto max-w-7xl px-6">
                            <h2 className="mb-12 text-center text-3xl font-bold text-gray-800 dark:text-gray-100">
                                🌟 Why Choose FreshDoor?
                            </h2>
                            <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                                <div className="rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-4xl">🛍️</div>
                                    <h3 className="mb-3 text-xl font-semibold">Wide Product Range</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Fresh groceries, household essentials, personal care items, and more
                                    </p>
                                </div>
                                <div className="rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-4xl">🚚</div>
                                    <h3 className="mb-3 text-xl font-semibold">Door-to-Door Delivery</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Convenient delivery right to your doorstep with flexible scheduling
                                    </p>
                                </div>
                                <div className="rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-4xl">💳</div>
                                    <h3 className="mb-3 text-xl font-semibold">Flexible Payment</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        COD, bank transfer, QRIS, and credit/installment options available
                                    </p>
                                </div>
                                <div className="rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-4xl">📱</div>
                                    <h3 className="mb-3 text-xl font-semibold">Easy Ordering</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        User-friendly platform with smart search and cart management
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* How It Works */}
                    <section className="py-20">
                        <div className="mx-auto max-w-7xl px-6">
                            <h2 className="mb-12 text-center text-3xl font-bold text-gray-800 dark:text-gray-100">
                                📋 How It Works
                            </h2>
                            <div className="grid gap-8 md:grid-cols-3">
                                <div className="text-center">
                                    <div className="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl dark:bg-green-900">1️⃣</div>
                                    <h3 className="mb-3 text-xl font-semibold">Browse & Add to Cart</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        🔍 Search through our wide selection of fresh groceries and household essentials
                                    </p>
                                </div>
                                <div className="text-center">
                                    <div className="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl dark:bg-green-900">2️⃣</div>
                                    <h3 className="mb-3 text-xl font-semibold">Choose Delivery Time</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        📅 Select your preferred delivery date and time slot that works for you
                                    </p>
                                </div>
                                <div className="text-center">
                                    <div className="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl dark:bg-green-900">3️⃣</div>
                                    <h3 className="mb-3 text-xl font-semibold">Get Fresh Delivery</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        🚪 Receive your fresh groceries right at your door with our reliable delivery service
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* Special Features */}
                    <section className="bg-green-50 py-20 dark:bg-gray-800/50">
                        <div className="mx-auto max-w-7xl px-6">
                            <h2 className="mb-12 text-center text-3xl font-bold text-gray-800 dark:text-gray-100">
                                ✨ Special Features
                            </h2>
                            <div className="grid gap-8 md:grid-cols-2">
                                <div className="rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
                                    <h3 className="mb-4 flex items-center text-xl font-semibold">
                                        💰 <span className="ml-3">Credit & Installment System</span>
                                    </h3>
                                    <p className="mb-4 text-gray-600 dark:text-gray-300">
                                        Apply for credit to shop now and pay later with our flexible TOP (Terms of Payment) system
                                    </p>
                                    <ul className="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                        <li>• Easy credit application process</li>
                                        <li>• Flexible payment terms</li>
                                        <li>• Admin approval system</li>
                                        <li>• Track your credit limit</li>
                                    </ul>
                                </div>
                                <div className="rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
                                    <h3 className="mb-4 flex items-center text-xl font-semibold">
                                        🎯 <span className="ml-3">Smart Shopping Experience</span>
                                    </h3>
                                    <p className="mb-4 text-gray-600 dark:text-gray-300">
                                        Advanced features to make your shopping experience seamless and enjoyable
                                    </p>
                                    <ul className="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                        <li>• Multiple delivery addresses</li>
                                        <li>• Order history tracking</li>
                                        <li>• Advanced product filtering</li>
                                        <li>• Real-time order notifications</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                {/* Footer */}
                <footer className="border-t border-green-200 bg-white/80 py-8 dark:border-gray-700 dark:bg-gray-900/80">
                    <div className="mx-auto max-w-7xl px-6 text-center">
                        <div className="mb-4 flex justify-center items-center space-x-2">
                            <div className="text-2xl">🛒</div>
                            <span className="text-lg font-bold text-green-600 dark:text-green-400">FreshDoor</span>
                        </div>
                        <p className="text-sm text-gray-600 dark:text-gray-400">
                            🏠 Your trusted door-to-door grocery delivery platform for monthly household essentials
                        </p>
                        <p className="mt-4 text-xs text-gray-500 dark:text-gray-500">
                            Built with ❤️ by{" "}
                            <a 
                                href="https://app.build" 
                                target="_blank" 
                                className="font-medium text-green-600 hover:underline dark:text-green-400"
                            >
                                app.build
                            </a>
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}