import React, { useEffect, useState } from 'react';
import { Link } from "@inertiajs/react";
import Modal from "@/Components/Modal";
import axios from "axios";

function Card(props) {
    const [showStockInfo, setShowStockInfo] = useState(false);
    const [modalData, setModalData] = useState({
        name: '',
        description: '',
        image: '',
        colors: []
    })

    const initialState = {
        name: '',
        description: '',
        image: '',
        colors: []
    }

    const baseUrl = "http://promobox-laravel.test/api/model-info";

    const modalInfo = () => {
        axios.get(`${baseUrl}/${props.name}`)
            .then((response) => {
                setModalData({
                    id: response.data.Id,
                    name: response.data.Name,
                    description: response.data.Description,
                    image: response.data.ImageWebP,
                    colors: response.data.Colors
                });
            })
            .catch(e => console.log(e))
    }

    const clearState = () => {
        setModalData({...initialState})
    }

    const openModal = () => {
        modalInfo()
        setShowStockInfo(true);

    }
    const closeModal = () => {
        setShowStockInfo(false);
        clearState()
    }
    return (
        <div className="card flex flex-col w-1/2 h-full border p-5 transition ease-in shadow-lg rounded-lg hover:border-black lg:w-[270px]">
            <div className="flex justify-between">
                <div className="group">
                    <img src={props.image}
                         alt="" className="w-32 md:w-36 lg:w-28 2xl:w-44 md:shrink group-hover:hidden" />
                    <img src={props.imageHover}
                         alt="" className="w-32 md:w-36 lg:w-28 2xl:w-44 md:shrink hidden group-hover:block" />
                </div>
                <div className="flex flex-col basis-10 items-end space-y-1">
                    {props.status && props.status.map((status, index) => {
                        return (
                            <img key={index}
                                 src={status[0].image}
                                 className="h-10" alt="" />
                        )
                    })}
                </div>
            </div>
            <span className="text-xs text-gray-600">{props.code}</span>
            <Link href={route('models.show', props.id)} className="w-fit">
                <h3 className="text-sm font-bold uppercase md:text-xl">{props.name}</h3>
            </Link>
            <div className="text-xs text-gray-700 flex-1">{props.description}</div>
            <div className="flex flex-col justify-end">
                <span className="flex items-center text-lg font-bold mt-3">{props.price}&euro;</span>
                <div className="flex flex-col justify-end mb-3">
                    <span className="block text-xs text-gray-400">Zalihe: {props.stock}</span>
                    <button onClick={openModal}
                            className="block text-xs text-left w-fit text-blue-600 transition ease-in duration-500 hover:underline">Prikaz
                                                                                                                                    zaliha
                    </button>
                </div>
                <div className="flex items-end -space-x-1 overflow-hidden">
                    <div
                        className="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-orange-300"></div>
                </div>
                <Modal show={showStockInfo} onClose={closeModal} maxWidth="7xl">
                    <div>
                        <header className="px-5 flex justify-between items-center">
                            <div className="flex items-center space-x-3">
                                <img src={modalData.image}
                                     className="w-36"
                                     alt="" />
                                <div>
                                    <h3 className="uppercase font-bold">{modalData.name}</h3>
                                    <span className="text-sm text-gray-400">{modalData.description}</span>
                                </div>
                            </div>
                            <div className="">
                                <select name="#" id="#" className="w-64 rounded-md border-gray-400">
                                    <option value="0">Izaberi boju</option>
                                    {modalData.colors.map((color, index) => {
                                        return (
                                            <option key={index} value="0">

                                            </option>
                                        )
                                    })}
                                </select>
                            </div>
                        </header>
                        <section>
                            <table className="w-full border-collapse">
                                <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-4 font-medium text-gray-900"></th>
                                    <th className="px-6 py-4 font-medium text-gray-900">Cena</th>
                                    <th className="px-6 py-4 font-medium text-gray-900">Zalihe</th>
                                    <th className="px-6 py-4 font-medium text-gray-900">Rezervisano</th>
                                    <th className="px-6 py-4 font-medium text-gray-900">Dolazak</th>
                                </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-100 border-t border-gray-100">
                                {modalData.colors.map((c, index) => {
                                    return (
                                        <tr key={index} className="hover:bg-gray-50">
                                            <th className="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                                <div className={`relative border border-gray-300 rounded-full h-10 w-10 bg-[${c.HtmlColor}]}`} style={{background: `${c.HtmlColor}`}}>
                                                    {/*<img src="https://apiv2.promosolution.services/Content/Images/Shade/transparent.png"*/}
                                                    {/*     className="rounded-full object-cover object-center"*/}
                                                    {/*     alt="" />*/}
                                                </div>
                                                <div className="text-sm text-left">
                                                    <div className="font-medium text-gray-500">
                                                        {(c.Sizes.length > 1) ? c.Sizes[index].Product.ProductIdView : c.Sizes[0].Product.ProductIdView}
                                                    </div>
                                                    <div className="text-gray-400">{c.Name}</div>
                                                </div>
                                            </th>
                                            <td className="text-center">
                                                <div className="font-medium">
                                                    {(c.Sizes.length > 1) ? c.Sizes[index].Product.Price : c.Sizes[0].Product.Price}&euro;
                                                </div>
                                            </td>
                                            <td className="text-center">
                                                <div className="font-medium">
                                                    {/*{(c.Sizes.length > 1) ? c.Sizes[index].Product.Stock : c.Sizes[0].Product.Price}*/}
                                                    {c.Sizes[0].Product.Stocks[index]?.Qty}
                                                </div>
                                            </td>
                                            <td className="text-center">
                                                <div className="font-medium">

                                                </div>
                                            </td>
                                            <td className="text-center">
                                                <div className="font-medium">

                                                </div>
                                            </td>
                                        </tr>
                                    )
                                })}
                                </tbody>
                            </table>
                        </section>
                    </div>
                </Modal>
            </div>
        </div>
    );
}

export default Card;