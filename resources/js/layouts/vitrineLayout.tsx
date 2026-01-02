// layouts/VitrineLayout.tsx
import Header from "@/components/Vitrine/header";
import React, { ReactNode } from "react";

type Props = { children: ReactNode };

export default function VitrineLayout({ children }: Props) {
    return (
        <>
            <Header />
            <main style={{ padding: "2rem" }}>{children}</main>
            <footer>

            </footer>
        </>
    );
}
