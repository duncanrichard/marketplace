import React, { useState } from 'react';
import ReactDOM from 'react-dom/client';
import '../css/app.css';


function ProductCard({ product, onAddToCart }) {
  return (
    <div className="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
      <img
        src={product.image}
        alt={product.name}
        className="w-full h-48 object-cover"
      />
      <div className="p-4">
        <h2 className="text-lg font-semibold text-gray-800">{product.name}</h2>
        <p className="text-sm text-gray-500 mb-2">{product.description}</p>
        <p className="text-md font-bold text-green-600">Rp {product.price.toLocaleString()}</p>
        <button
          onClick={() => onAddToCart(product)}
          className="mt-3 w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"
        >
          Tambah ke Keranjang
        </button>
      </div>
    </div>
  );
}

function Cart({ cartItems, onCheckout }) {
  const total = cartItems.reduce((sum, item) => sum + item.price * item.qty, 0);

  return (
    <div className="bg-white rounded-xl shadow-md p-4 sticky top-4">
      <h2 className="text-xl font-bold mb-3">🛒 Keranjang</h2>
      {cartItems.length === 0 ? (
        <p className="text-gray-500">Belum ada item.</p>
      ) : (
        <>
          <ul className="space-y-2 mb-3">
            {cartItems.map((item, idx) => (
              <li key={idx} className="flex justify-between text-sm text-gray-700 border-b pb-1">
                <span>{item.name} × {item.qty}</span>
                <span>Rp {(item.price * item.qty).toLocaleString()}</span>
              </li>
            ))}
          </ul>
          <div className="font-semibold text-right mb-3 text-green-700">
            Total: Rp {total.toLocaleString()}
          </div>
          <button
            onClick={onCheckout}
            className="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700"
            disabled={cartItems.length === 0}
          >
            Checkout
          </button>
        </>
      )}
    </div>
  );
}

function DashboardToko() {
  const [cart, setCart] = useState([]);

  const products = [
    {
      id: 1,
      name: 'Kaos Keren',
      price: 75000,
      description: 'Kaos bahan cotton combed',
      image: 'https://source.unsplash.com/300x300/?tshirt',
    },
    {
      id: 2,
      name: 'Sepatu Sneakers',
      price: 250000,
      description: 'Sneakers gaya casual',
      image: 'https://source.unsplash.com/300x300/?sneakers',
    },
    {
      id: 3,
      name: 'Tas Ransel',
      price: 120000,
      description: 'Tas ransel untuk sekolah dan kerja',
      image: 'https://source.unsplash.com/300x300/?backpack',
    },
  ];

  const addToCart = (product) => {
    setCart((prev) => {
      const exists = prev.find((p) => p.id === product.id);
      if (exists) {
        return prev.map((p) =>
          p.id === product.id ? { ...p, qty: p.qty + 1 } : p
        );
      }
      return [...prev, { ...product, qty: 1 }];
    });
  };

  const handleCheckout = () => {
    alert('✅ Checkout berhasil!');
    setCart([]);
  };

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      <h1 className="text-3xl font-bold mb-6 text-center text-blue-800">
        🛍️ Marketplace Toko Richard
      </h1>
      <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
          {products.map((product) => (
            <ProductCard key={product.id} product={product} onAddToCart={addToCart} />
          ))}
        </div>
        <Cart cartItems={cart} onCheckout={handleCheckout} />
      </div>
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('app')).render(<DashboardToko />);
