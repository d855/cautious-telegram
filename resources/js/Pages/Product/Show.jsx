import React from 'react';
import { Head } from "@inertiajs/react";

function Show(props) {
    return (
        <>
            <Head title="Home"></Head>
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

                <main>
                    <div className="mt-10 text-xs px-5 text-gray-500">Svi proizvodi {'>'} Tehnologija <span className="font-bold text-black">{props.product.Name}</span>
                    </div>
                    <div className="px-3 mt-20">
                        <div>
                            <div className="colors flex space-x-4 mb-4">
                                {/*TODO: display avaialble colors of a product*/}
                                {props.product.Colors.map((color, index) => {
                                    return (
                                        <div key={index}
                                             className={`flex items-center justify-center w-8 h-8 rounded-full`}
                                             style={{background: `${color.HtmlColor}`}}>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 strokeWidth="1.5"
                                                 stroke="white"
                                                 className="w-5 h-5">
                                                <path strokeLinecap="round"
                                                      strokeLinejoin="round"
                                                      d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </div>
                                    )
                                })}
                            </div>
                            <div className="flex space-x-3">
                                <a href="" className="py-1 px-2 bg-gray-200 rounded-full text-xs">Logo studio</a>
                                <a href="" className="py-1 px-2 bg-gray-200 rounded-full text-xs">Specifikacije</a>
                                <a href="" className="py-1 px-2 bg-gray-200 rounded-full text-xs">Prikaz zaliha</a>
                            </div>
                        </div>
                        <div className="flex flex-col space-y-7 mt-3">
                            <div>
                                <h1 className="font-bold tracking-wide">
                                    {/*<span>{props.product.}</span> {props.product.Model.Name} - {props.product.Model.Description}*/}
                                </h1>
                            </div>
                            <div>
                                {/*<span className="font-bold text-2xl">{props.product.Price}&euro;</span>*/}
                            </div>
                            <div>
                                <div className="font-bold">Zalihe</div>
                            </div>
                        </div>

                        <div className="md:max-w-2xl">
                            <div className="mt-5">
                                <h3 className="text-xs font-bold uppercase">Opste informacije</h3>

                                <table className="w-4/5 mt-5 text-xs">
                                    <tbody>
                                    <tr className="leading-loose">
                                        <td>Sifra</td>
                                        <td>10.194.30</td>
                                    </tr>
                                    <tr className="leading-loose">
                                        <td>Model</td>
                                        <td>{props.product.Name}</td>
                                    </tr>
                                    <tr className="leading-loose">
                                        <td>Boja</td>
                                        <td>Crvena</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}

export default Show;