// components/Hero.tsx
import React from "react";

export default function Hero() {
  return (
    <section className="text-center py-32 bg-gray-50">
      <h1 className="text-5xl font-extrabold mb-4">TonOutil — Développe vite, scale très grand</h1>
      <p className="text-xl text-gray-700 mb-8">
        Un backend complet et moderne, prêt à l’emploi, conçu pour les développeurs.
      </p>
      <div className="space-x-4">
        <button className="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Commencer</button>
        <button className="px-6 py-3 border rounded hover:bg-gray-100">Demander une démo</button>
      </div>
    </section>
  );
}
