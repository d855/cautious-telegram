import React, { useEffect, useState } from 'react';

function MultiSizeProduct(props) {
    let sizes = [];
    let sizesUnique = [];
    for (let i = 0; i < props.colors.length; i++) {
        for (let j = 0; j < props.colors[i].Sizes.length; j++) {
            sizes.push(props.colors[i]?.Sizes[j].Id)
        }
    }
    sizesUnique = Array.from(new Set(sizes))
    return (
        <div className="max-h-[700px] overflow-y-auto">
            <header className="px-5 py-5 flex justify-between items-center">
                <div className="flex items-center space-x-3">
                    <img src={props.image}
                         className="w-36"
                         alt="" />
                    <div>
                        <h3 className="uppercase font-bold">{props.name}</h3>
                        <span className="text-sm text-gray-700">{props.description}</span>
                    </div>
                </div>
                <div>
                    <select name="#" id="#" className="w-80 rounded-md border-gray-400">
                        <option value="0">Izaberi boju</option>
                        {props.colors.map((color, index) => {
                            return (
                                <option key={index} value="0" className="flex">
                                    {color.Name}
                                </option>
                            )
                        })}
                    </select>
                </div>
            </header>
            <section>
                <table className="w-full border-collapse">
                    <thead className="bg-gray-100">
                    <tr>
                        <th className="px-6 py-4 w-fit font-medium text-gray-900"></th>
                        <th className="px-6 py-4 font-medium text-gray-900"></th>
                        <th className="px-6 py-4 font-medium text-gray-900"></th>
                        {sizesUnique.map((size, index) => {
                            return (
                                <th key={index} className="px-6 py-4 font-medium text-gray-900">{size}</th>
                            )
                        })}
                    </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-100 border-t border-gray-100">
                    {props.colors.map((c, index) => {
                        return (
                            <tr key={index} className="hover:bg-gray-50">
                                <td className="flex gap-3 pl-6 py-4 font-normal text-gray-900">
                                    <div className={`relative border border-gray-300 rounded-full h-10 w-10`}
                                         style={{background: `${c.HtmlColor}`}}>
                                    </div>
                                    <div className="text-sm text-left">
                                        <div className="font-medium text-gray-500">
                                            {c.Sizes[0]?.Product.ProductIdView.slice(0, c.Sizes[0]?.Product.ProductIdView.indexOf('-'))}
                                        </div>
                                        <div className="text-gray-400">{c.Name}</div>
                                    </div>
                                </td>
                                <td className="text-left">
                                    <div className="text-sm">
                                        Cena <br />
                                        Zalihe <br />
                                        {}
                                        Rezervisano <br />
                                        Dolazak <br />
                                    </div>
                                </td>
                                <td className="text-center"></td>
                                {sizesUnique.map((s, index) =>
                                    <td key={index} className="text-center text-sm py-1">
                                        {c.Sizes.map((size, index) => {
                                            return (
                                                s === size.Id &&
                                                <>
                                                    <div>{size.Product.Price} &euro;</div>
                                                    <div>{size.Product.Stocks.map((stock) => {
                                                        if (stock.Warehouse === 'Warehouse1' || stock.Warehouse === 'Warehouse2') {
                                                            return stock.Qty
                                                        }
                                                    }).reduce((accumulator, currentValue) => {
                                                        // console.log(`acc:` + a, 'current:' + b)
                                                        return accumulator + currentValue > 0 ? accumulator + currentValue : 'Nedostupno'
                                                    }, 0).toLocaleString('en-US')
                                                    }</div>
                                                    <div>
                                                        {size.Product.Stocks[2]?.Warehouse === 'Warehouse3' ? size.Product.Stocks[2].Qty : '-'}
                                                    </div>
                                                    <div title="nesto">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             fill="none"
                                                             viewBox="0 0 24 24"
                                                             strokeWidth={1.5}
                                                             stroke="currentColor"
                                                             className="w-5 h-5 mx-auto">
                                                            <path strokeLinecap="round"
                                                                  strokeLinejoin="round"
                                                                  d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                                        </svg>
                                                    </div>
                                                </>
                                            )
                                        })}
                                    </td>
                                )}
                                {/*{c.Sizes.map((size, index) =>*/}
                                {/*    <td key={index} className="text-center">*/}
                                {/*        <div className="text-sm">*/}
                                {/*            {*/}
                                {/*                size.Product.Price*/}
                                {/*            }*/}
                                {/*            <br/>*/}
                                {/*{*/}
                                {/*    size.Product.Stocks.map((stock) => {*/}
                                {/*        if (stock.Warehouse === 'Warehouse1' || stock.Warehouse === 'Warehouse2') {*/}
                                {/*            return (stock.Qty)*/}
                                {/*        }*/}
                                {/*    }).reduce((a, b) => {*/}
                                {/*        return a + b > 0 ? a + b : 'Nedostupno'*/}
                                {/*    }, 0).toLocaleString('en-US')*/}
                                {/*}*/}
                                {/*            <br/>*/}
                                {/*            <div>da</div>*/}
                                
                                
                                {/*        </div>*/}
                                {/*    </td>*/}
                                {/*)}*/}
                            </tr>
                        )
                    })}
                    </tbody>
                </table>
            </section>
        </div>
    );
}

export default MultiSizeProduct;