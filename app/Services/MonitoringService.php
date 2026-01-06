<?php

namespace App\Services;

class MonitoringService
{
    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('GRAFANA_URL');
        $this->apiKey = env('GRAFANA_API_KEY');
    }

    public function getCpuByInstance($namespace)
    {
        $promql = sprintf(
            'sum(max(node_namespace_pod_container:container_cpu_usage_seconds_total:sum_rate5m{namespace="%s"})) / sum(kube_pod_container_resource_requests{job="kube-state-metrics",namespace="%s",resource="cpu"})',
            $namespace,
            $namespace
        );

        // URL encode
        $url = "http://149.202.75.201:32467/api/v1/query?query=" . urlencode($promql);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        var_dump($data['data']['result'][0]['value'][1] * 100);

        if (isset($data['data']['result'][0]['value'][1])) {
            return $data['data']['result'][0]['value'][1];
        }

        return null;
    }
}
