<?php
header("Content-Type: Application/JSON");
require_once ("../src/bootstrap.php");

$result = array(
    'error' => false
);

if (isset($_GET['initDate']) && isset($_GET['finalDate'])) {
    try {
        $initDate = new DateTime($_GET['initDate']);
        $finalDate = new DateTime($_GET['finalDate']);
    } catch (Exception $e) {
        $result['error'][] = "Formato de data inválido.";
        $result['exception'][] = $e->getMessage();
    }
} else {
    $result['error'][] = "Os parâmetros initDate e finalDate são obrigatórios";
}

if ($initDate >= $finalDate) {
    $result['error'][] = "A data final deve ser pelo menos um dia maior que a data inicial";
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $blog = new Model\Blog();
    $post = $blog->getById($id);
    $result['post'] = array(
        'title' => $post->getTitle(),
        'timestamp' => $post->getTimestamp()->format('Y-m-d H:i:s'),
        'visible' => $post->getVisible()
    );
    if ($post) {
        $result['data'] = array();
        $views = $post->getViews($initDate, $finalDate, true);
        $table = array(
            'days' => array(),
            'views' => array()
        );
        
        $start = clone $initDate;
        $end = clone $finalDate;
        
        // Tabela temporária contendo todos as datas que possuem pageviews
        $tempTable = array();
        foreach ($views as $view) {
            $date = new DateTime($view['date']);
            
            $month = substr(Extensions\Strings::monthName($date->format('n')), 0, 3);
            $label = $date->format('d') . "/$month";
            
            if ($date->format('d') == "01" && $month == "jan") {
                $label .= "/" . $start->format('Y');
            }
            
            $tempTable[$label] = $view['total'];
        }
        
        // Alimenta a tabela com todas as datas do intervalo e com os pageviews
        // Caso não haja pageviews para uma determinada data do intervalo, preenche com 0
        while ($start < $end) {
            $month = substr(Extensions\Strings::monthName($start->format('n')), 0, 3);
            $label = $start->format('d') . "/$month";
            
            if ($start->format('d') == "01" && $month == "jan") {
                $label .= "/" . $start->format('Y');
            }
            
            $table['days'][] = $label;
            
            if (array_key_exists($label, $tempTable)) {
                $table['views'][] = $tempTable[$label];
            } else {
                $table['views'][] = 0;
            }
            
            $start->modify('+1 day');
        }
        
        unset($tempTable);
        
        $result['table'] = $table;
    } else {
        $result['error'][] = "Post não encontrado";
    }
}

print_r(json_encode($result));