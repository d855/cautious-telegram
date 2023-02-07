import { Head } from "@inertiajs/react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper";
import 'swiper/css/bundle';
import Card from "@/Components/Card";
import config from  '../config.json'

const slider1_images = [
    'https://promobox.com/wp-content/uploads/2022/09/KUTIJE.webp',
    'https://promobox.com/wp-content/uploads/2023/01/Touch-olovke-slide-za-sajt.webp',
    'https://promobox.com/wp-content/uploads/2023/01/Cliff_slider.webp',
    'https://promobox.com/wp-content/uploads/2023/01/Bolton_slide.webp',
    'https://promobox.com/wp-content/uploads/2022/12/Jumper-Jupiter-Joker-Joker-lady_slider-4.webp',
    'https://promobox.com/wp-content/uploads/2022/11/Slide_Spot-Yard-pad.webp'
]
const insta_slider = [
    'https://scontent-frt3-2.cdninstagram.com/v/t51.29350-15/327263531_726526565493177_9129397074060107353_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=2bIpYB8QCAsAX9GgMcl&_nc_ht=scontent-frt3-2.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfDJYPTYRgbn-ZrPEAGnUYfrNZgJDaGaaNC87hAbYoZOtg&oe=63E25E46',
    'https://scontent-frx5-1.cdninstagram.com/v/t51.29350-15/326608384_3455781324657498_8411368012147793970_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=bErZd5MkJaIAX_TeZ0I&_nc_ht=scontent-frx5-1.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfCFqFLrs1IedXIr7x_jpqkWL4fcx_KZAgVjYiXHGfGH-A&oe=63E1BFBD',
    'https://scontent-frx5-1.cdninstagram.com/v/t51.29350-15/326151319_755786025449980_1660911364125243851_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=eR9P-eAKOS8AX8mLZ-_&_nc_ht=scontent-frx5-1.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfATBySYxGLbON-BjDbsDeJyiDXlWf6-H356eAli1x-PEg&oe=63E0FAC4',
    'https://scontent-frx5-1.cdninstagram.com/v/t51.29350-15/326069106_144672978401804_4807509277798102786_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=yMTrsi-F46IAX-tCzaC&_nc_ht=scontent-frx5-1.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfAkXXIYtlBwc5lZO6kYrVBjioRkuuc3vCLRQKr36DV9aQ&oe=63E1E581',
    'https://scontent-frt3-2.cdninstagram.com/v/t51.29350-15/325462746_732705761382902_6606770487167584246_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=fn611wcDL9wAX9FBg_I&_nc_ht=scontent-frt3-2.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfBwX_u9dT20DeUQRdYtuvHAcLw4BS9RkpayYwRntBy0JQ&oe=63E12429',
    'https://scontent-frt3-2.cdninstagram.com/v/t51.29350-15/324841091_183120264319556_1716880719094959215_n.jpg?_nc_cat=107&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=a4BQ7QiRxdgAX9rqUCb&_nc_ht=scontent-frt3-2.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfCYDn7T25QzFRrp2uj5KtUKbykoFsUhCOG7_APHNXvFDw&oe=63E18296',
    'https://scontent-frx5-1.cdninstagram.com/v/t51.29350-15/321935374_830097148282903_5994465963047221776_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=MoEfX7xrkH8AX-HmPvp&_nc_ht=scontent-frx5-1.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfCC9ZCCs-Kxmusf4qWDglwWh4zT7Mtb6rPQkbmdEM5tug&oe=63E1A9E9',
    'https://scontent-frx5-1.cdninstagram.com/v/t51.29350-15/323701604_707565530877195_447145571966200877_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=Gy2pzgx-eboAX8IuANt&_nc_ht=scontent-frx5-1.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfBufF6Onepl75X9z8-1JtYKoQ8sD-VffhRRe3wnyheMFw&oe=63E1A5ED',
    'https://scontent-frx5-1.cdninstagram.com/v/t51.29350-15/323688553_183645907678943_3292041488657846710_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=9qa4dUxTQDsAX8NmZ9U&_nc_oc=AQlJghxpqBi8D1whCLmYmE3LMGHwA0sQytdUrt-DOxbBG-xTDCRFVsFKC9v_uzCfHXM&_nc_ht=scontent-frx5-1.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfATu8nDazeLyAHrASoxldvu_wWhMjntpkhJI0ma5B6IrA&oe=63E28D86',
    'https://scontent-frt3-2.cdninstagram.com/v/t51.29350-15/324562385_111406378417585_5451360344613599645_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=8ae9d6&_nc_ohc=TPD42yXAC_UAX_0IVry&_nc_ht=scontent-frt3-2.cdninstagram.com&edm=ANo9K5cEAAAA&oh=00_AfAMzA-_3wh_mFxUEeLSn-6CjLCht1diKWB_I4_kxPDE1A&oe=63E0D2A4',

]

export default function Home(props) {
    const {site_url} = config;
    console.log(site_url);
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
                    <div className="px-3 py-5">
                        <Swiper slidesPerView={1}
                                loop={true}
                                modules={[Navigation, Pagination, Autoplay]}
                                responsive={{}}
                                pagination
                                navigation
                                autoplay
                                className="swiper-1">
                            {slider1_images.map((img, i) => {
                                return (
                                    <SwiperSlide key={i}>
                                        <img className="w-full" src={img} alt="" />
                                    </SwiperSlide>
                                )
                            })}
                        </Swiper>
                    </div>
                    <section className="noviteti py-20">
                        <div>
                            <h2 className="w-fit text-center text-2xl font-bold tracking-wide mx-auto p-4 lg:text-3xl">
                                Noviteti
                            </h2>
                        </div>
                        <div className="swiper-container">
                            <Swiper modules={[Navigation, Autoplay]}
                                    autoplay={{pauseOnMouseEnter: true}}
                                    navigation
                                    slidesPerView={5}
                                    loop={true}
                                    touchRatio={1.5}
                                    spaceBetween={20}
                                    className="swiper-2">
                                {props.latest.data.map((product, index) => {
                                    return (
                                        <SwiperSlide key={index}>
                                            <Card name={product.name}
                                                  id={product.id}
                                                  image={product.imageWebP}
                                                  imageHover={product.imageHover ? product.imageHover : product.imageWebP}
                                                  price={product.minPrice}
                                                  code={product.display_code}
                                                  stock={parseInt(product.stock)}
                                                  status={product.status}
                                                  shades={product.shades}
                                                  description={product.description['sr']}></Card>
                                        </SwiperSlide>
                                    )
                                })}
                            </Swiper>
                        </div>
                    </section>
                    <section className="featured px-5 mt-20">
                        <div className="div1">
                            <a href="#">
                                <img src="https://promobox.com/wp-content/uploads/2022/09/BASICS.webp" alt="" />
                            </a>
                        </div>
                        <div className="div2">
                            <a href="">
                                <img src="https://promobox.com/wp-content/uploads/2022/09/mali-baner.webp" alt="" />
                            </a>
                        </div>
                        <div className="div3">
                            <a href="">
                                <img src="https://promobox.com/wp-content/uploads/2022/09/Srb-katalog.webp" alt="" />
                            </a>
                        </div>
                        <div className="div4">
                            <a href="">
                                <img src="https://promobox.com/wp-content/uploads/2022/09/RS_Banner_02.webp" alt="" />
                            </a>
                        </div>
                    </section>
                    <section className="my-20">
                        <div className="flex items-center justify-center lg:mb-5">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                     width="24" height="24"
                                     viewBox="0 0 48 48">
                                    <path d="M 16.5 5 C 10.159 5 5 10.159 5 16.5 L 5 31.5 C 5 37.841 10.159 43 16.5 43 L 31.5 43 C 37.841 43 43 37.841 43 31.5 L 43 16.5 C 43 10.159 37.841 5 31.5 5 L 16.5 5 z M 34 12 C 35.105 12 36 12.895 36 14 C 36 15.104 35.105 16 34 16 C 32.895 16 32 15.104 32 14 C 32 12.895 32.895 12 34 12 z M 24 14 C 29.514 14 34 18.486 34 24 C 34 29.514 29.514 34 24 34 C 18.486 34 14 29.514 14 24 C 14 18.486 18.486 14 24 14 z M 24 17 A 7 7 0 1 0 24 31 A 7 7 0 1 0 24 17 z"></path>
                                </svg>
                            </a>
                            <h2 className="text-2xl ml-2">Pratite nas</h2>
                        </div>
                        <div className="swiper-container">
                            <Swiper slidesPerView={6}>
                                {insta_slider.map((img, i) => {
                                    return (
                                        <SwiperSlide key={i}>
                                            <a href="#" className="relative">
                                                <img className="h-60 sm:w-60 lg:h-44 xl:h-56 object-cover object-center"
                                                     src={img}
                                                     alt="" />
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     strokeWidth="1.5"
                                                     stroke="white"
                                                     className="w-4 h-4 absolute top-2 right-5">
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                          d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                                </svg>
                                            </a>
                                        </SwiperSlide>
                                    )
                                })}
                            </Swiper>
                        </div>
                    </section>
                </main>
            </div>
            <footer className="border-t">
                <div className="pt-10 pb-5 px-7 xl:container mx-auto sm:flex sm:flex-wrap lg:flex-nowrap">
                    <div className="sm:border-r sm:w-1/2 lg:w-1/4">
                        <div>
                            <img src="https://promobox.com/wp-content/themes/promobox/img/promobox-logo.svg" alt="logo"
                                 className="w-40" />
                            <span className="text-xs text-gray-300 tracking-wide">PromoBox &copy; Sva prava zadrzana.</span>
                        </div>
                        <a href="#" className="text-xs text-gray-500 tracking-wide">Powered by Digital2.rs</a>
                    </div>
                    
                    <div className="flex flex-col justify-start mt-2 text-xs tracking-wide sm:pl-16 lg:w-1/4 lg:border-r lg:pr-3 lg:text-sm lg:mt-0 xl:w-1/4">
                        <a href="#">Katalog promotivnih poklona 2022</a>
                        <a href="#">Katalog rokovnika i kalendara 2023</a>
                        <a href="#">Marketing alati</a>
                    </div>
                    
                    <div className="mt-10 sm:mt-0 sm:border-r sm:w-1/2 lg:w-1/5 lg:pl-5 xl:w-1/6 2xl:pl-16">
                        <div className="mb-5 xl:mb-8 2xl:text-sm">Pratite nas</div>
                        
                        <div className="flex space-x-3 lg:space-x-1 lg:justify-start">
                            <a href="">
                                <img src="https://promobox.com/wp-content/themes/promobox/img/facebook.svg"
                                     alt=""
                                     className="w-6 h-6 lg:w-7 lg:h-7" />
                            </a>
                            <a href="#">
                                <img src="https://promobox.com/wp-content/themes/promobox/img/instagram.svg"
                                     alt=""
                                     className="w-6 h-6 lg:w-7 lg:h-7" />
                            </a>
                            <a href="#">
                                <img src="https://promobox.com/wp-content/themes/promobox/img/linkedin.svg"
                                     alt=""
                                     className="w-6 h-6 lg:w-7 lg:h-7" />
                            </a>
                            <a href="#">
                                <img src="https://promobox.com/wp-content/themes/promobox/img/youtube.svg"
                                     alt=""
                                     className="w-6 h-6 lg:w-7 lg:h-7" />
                            </a>
                        </div>
                    </div>
                    
                    <div className="flex flex-col text-xs mt-5 sm:mt-0 sm:pl-16 lg:pl-10">
                        <div>
                            <a href="#">marketing@promobox.com</a><br />
                            Prijavite se na nas newsletter
                        </div>
                        
                        <div className="mt-3">
                            <form action="#">
                                <input type="search" placeholder="Vasa email adresa"
                                       className="py-1 px-2 border border-gray-400 rounded-full lg:w-36 2xl:w-64" />
                                
                                <button className="text-xs leading-none bg-gray-200 px-3 py-2 rounded-full 2xl:px-7">Posalji</button>
                            </form>
                        </div>
                    </div>
                </div>
            </footer>
        </>
    )
}