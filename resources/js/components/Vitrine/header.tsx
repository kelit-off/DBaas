// components/Header.tsx
'use client'

import { useState } from 'react'
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/react'
// import { ChevronDownIcon } from '@heroicons/react/20/solid'
import { Link } from '@inertiajs/react'
import { CircleChevronDown } from 'lucide-react'

// Exemple d'icônes personnalisées
// import { DatabaseIcon, AuthIcon, StorageIcon } from './Icons'

type MenuItem = {
    title: string
    description?: string
    href?: string
    icon?: React.ElementType
    children?: MenuItem[]
}

const menuItems: MenuItem[] = [
    {
        title: 'Products',
        children: [
            { title: 'Database', description: 'Fully portable Postgres database', href: '/database'},
            { title: 'Authentication', description: 'User Management out of the box', href: '/auth'},
            { title: 'Storage', description: 'Serverless storage for any media', href: '/storage'},
        ],
    },
    {
        title: 'Pricing',
        href: '/pricing',
    },
]

export default function Header() {
    return (
        <header className="border-b shadow-md px-8 py-4 w-full max-w-screen">
            <nav className="flex items-center w-full">
                <div className="font-bold text-lg">DBaaS</div>

                <div className="flex gap-6">
                    {menuItems.map((item) => (
                        <div key={item.title}>
                            {item.children?.length ? (
                                // Mega menu si item a des children
                                <Popover className="relative">
                                    <PopoverButton className="flex items-center gap-1 font-semibold">
                                        {item.title} <CircleChevronDown className="w-4 h-4" />
                                    </PopoverButton>

                                    <PopoverPanel className="absolute left-0 mt-2 w-[600px] bg-white border rounded-xl shadow-lg p-4 flex gap-6">
                                        {/* Colonne principale */}
                                        <div className="flex flex-col gap-3 w-[280px]">
                                            {item.children.map((child) => (
                                                <Link key={child.title} href={child.href || '#'}>
                                                    <div className="flex gap-3 p-2 hover:bg-gray-100 rounded-md">
                                                        {child.icon && (
                                                            <div className="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-lg">
                                                                <child.icon className="w-5 h-5 text-gray-600" />
                                                            </div>
                                                        )}
                                                        <div className="flex flex-col">
                                                            <span className="font-semibold">{child.title}</span>
                                                            {child.description && <span className="text-xs text-gray-500">{child.description}</span>}
                                                        </div>
                                                    </div>
                                                </Link>
                                            ))}
                                        </div>

                                        {/* Colonne secondaire (exemple fixe, tu peux la remplir dynamiquement) */}
                                        <div className="flex flex-col w-[280px] gap-4">
                                            <span className="uppercase text-xs font-mono text-gray-400">Modules</span>
                                            <Link href="/modules/vector" className="text-sm text-gray-600 hover:text-gray-800">
                                                Vector
                                            </Link>
                                            <Link href="/modules/cron" className="text-sm text-gray-600 hover:text-gray-800">
                                                Cron
                                            </Link>
                                        </div>
                                    </PopoverPanel>
                                </Popover>
                            ) : (
                                // Lien direct si pas d'enfant
                                <Link href={item.href || '#'} className="font-semibold">
                                    {item.title}
                                </Link>
                            )}
                        </div>
                    ))}
                </div>
            </nav>
        </header>
    )
}
