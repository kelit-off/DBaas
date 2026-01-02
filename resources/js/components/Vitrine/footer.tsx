// components/Footer.tsx
import React from "react";

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-gray-300 py-12 px-8 text-center">
      <p>&copy; 2026 TonOutil. Tous droits réservés.</p>
      <div className="mt-4 space-x-4">
        <a href="#" className="hover:text-white">Docs</a>
        <a href="#" className="hover:text-white">Blog</a>
        <a href="#" className="hover:text-white">Contact</a>
      </div>
    </footer>
  );
}
