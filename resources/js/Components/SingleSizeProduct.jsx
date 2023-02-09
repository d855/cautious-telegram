import React from 'react';

function SingleSizeProduct(props) {
    return (
        <div className="max-h-[500px] overflow-y-auto">
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
                        <th className="px-6 py-4 font-medium text-gray-900"></th>
                        <th className="px-6 py-4 font-medium text-gray-900">Cena</th>
                        <th className="px-6 py-4 font-medium text-gray-900">Zalihe</th>
                        <th className="px-6 py-4 font-medium text-gray-900">Rezervisano</th>
                        <th className="px-6 py-4 font-medium text-gray-900">Dolazak</th>
                    </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-100 border-t border-gray-100">
                    {props.colors.map((c, index) => {
                        return (
                            <tr key={index} className="hover:bg-gray-50">
                                <th className="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                    <div className={`relative border border-gray-300 rounded-full h-10 w-10`}
                                         style={{background: `${c.HtmlColor}`}}>
                                    </div>
                                    <div className="text-sm text-left">
                                        <div className="font-medium text-gray-500">
                                            {(c.Sizes.length > 1) ? c.Sizes[index].Product.ProductIdView : c.Sizes[0].Product.ProductIdView}
                                        </div>
                                        <div className="text-gray-400">{c.Name}</div>
                                    </div>
                                </th>
                                <td className="text-center">
                                    <div className="font-bold">
                                        {(c.Sizes.length > 1) ? c.Sizes[index].Product.Price.toFixed(2) : c.Sizes[0].Product.Price.toFixed(2)}&euro;
                                    </div>
                                </td>
                                <td className="text-center">
                                    <div className="font-medium">
                                        {c.Sizes[0].Product.Stocks.map((stock) => {
                                                if (stock.Warehouse === 'Warehouse1' || stock.Warehouse === 'Warehouse2') {
                                                    return (stock.Qty)
                                                }
                                            }).reduce((a, b) => a + b, 0).toLocaleString('en-US')
                                        }
                                    </div>
                                </td>
                                <td className="text-center">
                                    <div className="font-medium">
                                        {c.Sizes[0].Product.Stocks.map((stock) => {
                                            stock.Warehouse === 'Warehouse3' && stock.Qty
                                        })}
                                    </div>
                                </td>
                                <td className="text-center">
                                    <div>
                                        {props.arrival.map((arr) => {
                                            return (
                                                arr['product_id'] === c.Sizes[0].Product.Id ? arr['quantity'] + ' kom ' + arr['date'] : ''
                                            )
                                        })}
                                    </div>
                                </td>
                            </tr>
                        )
                    })}
                    </tbody>
                </table>
            </section>
        </div>
    );
}

export default SingleSizeProduct;