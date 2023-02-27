import React, { useState } from 'react';
import Card from "@/Components/Card";
import { Head } from "@inertiajs/react";

function Index(props) {
    
    return (
        <>
            <Head>
                <title>Products</title>
            </Head>
            <div className="container mx-auto">
                <header>
                    <div className="hidden lg:block px-3">
                        <div className="lg:flex justify-around items-center space-x-20 xl:space-x-40 mt-5 px-5 2xl:px-0">
                            <div className="flex-none">
                                <a href="/">
                                    <img src="https://promobox.com/wp-content/themes/promobox/img/promobox-logo.svg"
                                         className="h-7"
                                         alt="logo promovox" />
                                </a>
                            </div>
                            <div className="w-full">
                                <form>
                                    <div className="relative">
                                        <input type="search"
                                               placeholder="Pretraga"
                                               className="border border-black w-full rounded-full px-3 py-2 focus:ring-blue-400" />
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             strokeWidth="1.5"
                                             stroke="currentColor"
                                             className="absolute right-4 top-3 w-5 h-5">
                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                  d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </div>
                                </form>
                            </div>
                            <div className="flex-items-center text-sm space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     strokeWidth="1.5"
                                     stroke="currentColor"
                                     className="w-4 h-4">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                          d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>
                                
                                <span>RS</span>
                            </div>
                        </div>
                    </div>
                    <div className="nav-container mt-5">
                        <nav className="flex space-x-5 relative">
                            <a href="#"
                               className="flex items-center uppercase font-bold text-sm hover:bg-black hover:text-white rounded-full transition duration-300 ease-in px-4 py-1">
                                Proizvodi
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     strokeWidth="1.5"
                                     stroke="currentColor"
                                     className="ml-2 w-4 h-4">
                                    <path strokeLinecap="round"
                                          strokeLinejoin="round"
                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </a>
                            <a href="#"
                               className="flex items-center uppercase font-bold text-sm hover:bg-black hover:text-white rounded-full transition duration-300 ease-in px-4 py-1">Novo</a>
                            <a href="#"
                               className="flex items-center uppercase font-bold text-sm hover:bg-black hover:text-white rounded-full transition duration-300 ease-in px-4 py-1">Akcija</a>
                            <a href="#"
                               className="flex items-center uppercase font-bold text-sm hover:bg-black hover:text-white rounded-full transition duration-300 ease-in px-4 py-1">Specijalna
                                                                                                                                                                                ponuda</a>
                            <a href="#"
                               className="flex items-center uppercase font-bold text-sm hover:bg-black hover:text-white rounded-full transition duration-300 ease-in px-4 py-1">Rasprodaja%</a>
                            <a href="#"
                               className="flex items-center uppercase font-bold text-sm hover:bg-black hover:text-white rounded-full transition duration-300 ease-in px-4 py-1">Marketing
                                                                                                                                                                                alati</a>
                        </nav>
                    </div>
                </header>
                <div className="content mt-20 flex gap-10">
                    <aside className="w-1/5">
                        <div className="p-2 flex flex-col flex-auto flex-shrink-0 antialiased text-sm text-gray-800 space-y-2 rounded-md border border-gray-200">
                            <details>
                                <summary>Kategorija</summary>
                                {props.categories.map(category => {
                                    return (
                                        <details className="ml-5">
                                            <summary>{JSON.parse(category.name).sr}({category.count})</summary>
                                            {category.subcats.map(subc => {
                                                return (
                                                    <details className="ml-5">
                                                        <summary>{JSON.parse(subc.name).sr}({subc.count})</summary>
                                                        {subc.subcats?.map(subcc => {
                                                            return (
                                                                <details className="ml-5">
                                                                    <summary>{JSON.parse(subcc.name).sr}({subcc.count})</summary>
                                                                </details>
                                                            )
                                                        })}
                                                    </details>
                                                )
                                            })}
                                        </details>
                                    )
                                })}
                            </details>
                            <details>
                                <summary>Boja</summary>
                                <ul className="flex flex-wrap">
                                    {props.colors.map(color =>
                                        <li className={`w-5 h-5 mt-1 mr-2 rounded-full overflow-hidden`}
                                            style={{background: `${color.html}`}}>
                                            <img src={color.image}  alt="" />
                                        </li>
                                    )}
                                </ul>
                            </details>
                            <details>
                                <summary>Brend</summary>
                                <ul className="flex flex-col">
                                    {props.brands.map(brand =>
                                        <li className={`ml-2 mt-1 mr-2 rounded-full overflow-hidden`}>
                                            <input type="checkbox" className="rounded-full w-4 mr-2 focus:outline-none" />
                                            {brand.pid}
                                        </li>
                                    )}
                                </ul>
                            </details>
                            <details>
                                <summary>Velicina</summary>
                                <ul className="flex flex-col">
                                    {props.sizes.map(size =>
                                        <li className={`ml-2 mt-1 mr-2 rounded-full overflow-hidden`}>
                                            {size.pid}
                                        </li>
                                    )}
                                </ul>
                            </details>
                            <details>
                                <summary>Status</summary>
                                <ul className="flex flex-col">
                                    {props.statuses.map(status =>
                                        <li className={`ml-2 mt-1 mr-2 rounded-full overflow-hidden`}>
                                            <input type="checkbox" className="rounded-full w-4 mr-2 focus:outline-none" />
                                            {status.name.sr}
                                        </li>
                                    )}
                                </ul>
                            </details>
                            {props.stickers.map(sticker =>
                                <details>
                                    <summary>{JSON.parse(sticker.type).sr}</summary>
                                    <ul className="ml-5">
                                        {sticker.stickers.map(stick =>
                                            <li>{JSON.parse(stick.name).sr}({stick.count[0].broj})</li>
                                        )}
                                    </ul>
                                </details>
                            )}
                        </div>
                    </aside>
                    <main className="w-4/5">
                        <div className="grid grid-cols-1 lg:grid-cols-4 gap-y-10">
                            {props.products.data.map((product, index) =>
                                <Card key={index}
                                      name={product.name}
                                      id={product.id}
                                      image={product.imageWebP}
                                      imageHover={product.imageHover ? product.imageHover : product.imageWebP}
                                      price={product.price}
                                      code={product.display_code}
                                      stock={parseInt(product.stock)}
                                      status={product.status}
                                      shades={product.shades}
                                      description={product.description['sr']}></Card>
                            )}
                        </div>
                    </main>
                </div>
            </div>
        </>
    
    );
}

export default Index;