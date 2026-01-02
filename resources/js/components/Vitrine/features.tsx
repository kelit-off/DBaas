// components/Features.tsx
import React from "react";

const features = [
  { title: "Base de données", description: "Une base Postgres complète avec API instantanée." },
  { title: "Authentification", description: "Gestion simple et sécurisée des utilisateurs." },
  { title: "Realtime", description: "Recevez les mises à jour en temps réel." },
  { title: "Stockage", description: "Gérez vos fichiers et médias facilement." },
  { title: "Fonctions Edge", description: "Exécutez du code proche de vos utilisateurs." },
];

export default function Features() {
  return (
    <section id="features" className="py-20 px-8 bg-white text-center">
      <h2 className="text-4xl font-bold mb-12">Fonctionnalités clés</h2>
      <div className="grid md:grid-cols-3 gap-8">
        {features.map((f, i) => (
          <div key={i} className="p-6 border rounded shadow hover:shadow-lg transition">
            <h3 className="text-2xl font-semibold mb-2">{f.title}</h3>
            <p className="text-gray-600">{f.description}</p>
          </div>
        ))}
      </div>
    </section>
  );
}
