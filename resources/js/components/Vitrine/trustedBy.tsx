// components/TrustedBy.tsx
import React from "react";

const logos = [
  "/logos/logo1.png",
  "/logos/logo2.png",
  "/logos/logo3.png",
  "/logos/logo4.png",
];

export default function TrustedBy() {
  return (
    <section id="trusted" className="py-16 px-8 bg-gray-50 text-center">
      <h2 className="text-3xl font-bold mb-8">Fait confiance par les entreprises</h2>
      <div className="flex justify-center flex-wrap gap-8">
        {logos.map((logo, i) => (
          <img key={i} src={logo} alt={`Client ${i + 1}`} className="h-12 object-contain" />
        ))}
      </div>
    </section>
  );
}
