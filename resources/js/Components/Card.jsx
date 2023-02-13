import React, { useEffect, useState } from 'react';
import { Link } from "@inertiajs/react";
import Modal from "@/Components/Modal";
import axios from "axios";
import SingleSizeProduct from "@/Components/SingleSizeProduct";
import { data } from "autoprefixer";
import MultiSizeProduct from "@/Components/MultiSizeProduct";

function Card(props) {
    const [showStockInfo, setShowStockInfo] = useState(false);
    const [modalData, setModalData] = useState({
        name: '',
        description: '',
        image: '',
        colors: [],
    })
    const [dataArrival, setDataArrival] = useState({
        id: '',
        qty: '',
        date: ''
    });
    const initialState = {
        name: '',
        description: '',
        image: '',
        colors: []
    }
    const baseUrl = "http://promobox-laravel.test/api/";
    const modalInfo = () => {
        axios.all([
            axios.get(`${baseUrl}model-info/${props.name}`),
            axios.get(`${baseUrl}product-arrival/${props.id}`)
        ]).then(axios.spread((data1, data2) => {
            setModalData({
                id: data1.data.Id,
                name: data1.data.Name,
                description: data1.data.Description,
                image: data1.data.ImageWebP,
                colors: data1.data.Colors
            })
            setDataArrival(data2.data)
        }))
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
        <div className="card flex flex-col w-1/2 h-full p-5 transition ease-in shadow-lg rounded-lg border overflow-hidden hover:border-black lg:w-[270px] lg:h-[450px]">
            <div className="flex justify-between">
                <div className="group">
                    <img src={props.image}
                         alt="" className="w-32 md:w-36 lg:w-28 2xl:w-44 md:shrink group-hover:hidden" />
                    <img src={props.imageHover}
                         alt="" className="w-32 md:w-36 lg:w-28 2xl:w-44 md:shrink hidden group-hover:block" />
                </div>
                <div className="flex flex-col basis-10 items-end space-y-1">
                    {/*{props.status && props.status.map((status, index) => {*/}
                    {/*    return (*/}
                    {/*        <img key={index}*/}
                    {/*             src={status[0].image}*/}
                    {/*             className="h-10" alt="" />*/}
                    {/*    )*/}
                    {/*})}*/}
                </div>
            </div>
            <span className="text-xs text-gray-600">{props.code}</span>
            <Link href={route('models.show', props.id)} className="w-fit">
                <h3 className="text-sm font-semibold uppercase md:text-xl">{props.name}</h3>
            </Link>
            <div className="text-xs text-gray-800 flex-1">{props.description}</div>
            
            <div className="flex flex-col justify-end">
                <span className="flex items-center text-lg font-bold mt-3">{props.price}</span>
                <div className="flex flex-col space-y-2 justify-end mb-3">
                    <span className="block text-xs text-gray-700">Zalihe: {props.stock.toLocaleString('en-US')}</span>
                    <button onClick={openModal}
                            className="block text-xs text-left w-fit text-blue-600 transition ease-in duration-500 hover:underline">Prikaz
                                                                                                                                    zaliha
                    </button>
                </div>
                <div className="flex items-end -space-x-1 py-2 pl-px overflow-hidden">
                    {props.shades.map((shade, index) => {
                        return (
                            <div key={index}
                                 className={`inline-block h-6 w-6 rounded-full ring-1 ring-gray-200`}
                                 style={shade[0]?.html ? {background: `${shade[0].html}`} : {background: `url(${shade[0]?.image})`}}></div>
                        )
                    }).splice(0, 7)}
                
                </div>
                <Modal show={showStockInfo} onClose={closeModal} maxWidth="7xl">
                    {modalData?.colors[0]?.Sizes.length > 1 ?
                        <MultiSizeProduct image={modalData.image}
                                          name={modalData.name}
                                          description={modalData.description}
                                          arrival={dataArrival}
                                          colors={modalData.colors} />
                        :
                        <SingleSizeProduct image={modalData.image}
                                           name={modalData.name}
                                           description={modalData.description}
                                           arrival={dataArrival}
                                           colors={modalData.colors} />
                    }
                </Modal>
            
            </div>
        
        </div>
    );
}

export default Card;