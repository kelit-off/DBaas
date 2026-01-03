import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from "../ui/dropdown-menu";
import { Button } from "../ui/button";
import { UserInfo } from "../user-info";
import { UserMenuContent } from "../user-menu-content";

export default function NavUser() {
    const { auth } = usePage<SharedData>().props;

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button variant="ghost" className="px-0">
                    <UserInfo user={auth.user} showInfo={false} />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent>
                <UserMenuContent user={auth.user} />
            </DropdownMenuContent>
        </DropdownMenu>
    )
}
