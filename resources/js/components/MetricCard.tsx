import { Card, CardContent, CardHeader, CardTitle } from "./ui/card";

export default function MetricCard({
    title,
    subtitle,
    value,
}: {
    title: string;
    subtitle: string;
    value: number;
    type: string;
}) {

    switch (type) {
        case "queries":
            value = 12400;
            break;
        case "connections":
            value = 18;
            break;
        case "disk":
            value = 1.2;
            break;
        case "cpu":
            value = 23;
            break;
    }

    return (
        <Card>
            <CardHeader className="pb-2">
                <CardTitle className="text-sm text-neutral-400">
                    {title}
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div className="text-sm text-neutral-400">{subtitle}</div>
                <div className="text-2xl font-semibold mt-1">{value}</div>

                {/* Fake bars */}
                <div className="mt-4 flex gap-1">
                    {Array.from({ length: 10 }).map((_, i) => (
                        <div
                            key={i}
                            className="h-10 w-full rounded bg-emerald-500/80"
                        />
                    ))}
                </div>
            </CardContent>
        </Card>
    );
}
