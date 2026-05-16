<?php
    $total_cajas      = $insLogin->ejecutarConsulta("SELECT COUNT(caja_id) as total FROM caja");
    $total_cajas      = (int)$total_cajas->fetchColumn();

    $total_usuarios   = $insLogin->ejecutarConsulta("SELECT COUNT(usuario_id) as total FROM usuario WHERE usuario_id!='1' AND usuario_id!='".$_SESSION['id']."'");
    $total_usuarios   = (int)$total_usuarios->fetchColumn();

    $total_clientes   = $insLogin->ejecutarConsulta("SELECT COUNT(cliente_id) as total FROM cliente WHERE cliente_id!='1'");
    $total_clientes   = (int)$total_clientes->fetchColumn();

    $total_categorias = $insLogin->ejecutarConsulta("SELECT COUNT(categoria_id) as total FROM categoria");
    $total_categorias = (int)$total_categorias->fetchColumn();

    $total_productos  = $insLogin->ejecutarConsulta("SELECT COUNT(producto_id) as total FROM producto");
    $total_productos  = (int)$total_productos->fetchColumn();

    $total_ventas     = $insLogin->ejecutarConsulta("SELECT COUNT(venta_id) as total FROM venta");
    $total_ventas     = (int)$total_ventas->fetchColumn();

    $ingresos_total   = $insLogin->ejecutarConsulta("SELECT COALESCE(SUM(venta_total),0) as total FROM venta");
    $ingresos_total   = (float)$ingresos_total->fetchColumn();

    $ventas_hoy       = $insLogin->ejecutarConsulta("SELECT COALESCE(SUM(venta_total),0) FROM venta WHERE venta_fecha=CURDATE()");
    $ventas_hoy       = (float)$ventas_hoy->fetchColumn();

    $q_semana = $insLogin->ejecutarConsulta(
        "SELECT DATE_FORMAT(d.fecha,'%d/%m') AS label, COALESCE(SUM(v.venta_total),0) AS total
         FROM (
           SELECT CURDATE() - INTERVAL 6 DAY AS fecha UNION ALL
           SELECT CURDATE() - INTERVAL 5 DAY UNION ALL
           SELECT CURDATE() - INTERVAL 4 DAY UNION ALL
           SELECT CURDATE() - INTERVAL 3 DAY UNION ALL
           SELECT CURDATE() - INTERVAL 2 DAY UNION ALL
           SELECT CURDATE() - INTERVAL 1 DAY UNION ALL
           SELECT CURDATE()
         ) d
         LEFT JOIN venta v ON v.venta_fecha = d.fecha
         GROUP BY d.fecha ORDER BY d.fecha ASC"
    );
    $semana_labels = [];
    $semana_totales = [];
    foreach($q_semana->fetchAll() as $r){ $semana_labels[]=$r['label']; $semana_totales[]=(float)$r['total']; }

    $q_cat = $insLogin->ejecutarConsulta(
        "SELECT c.categoria_nombre, COUNT(p.producto_id) as total
         FROM categoria c LEFT JOIN producto p ON c.categoria_id=p.categoria_id
         GROUP BY c.categoria_id, c.categoria_nombre ORDER BY total DESC LIMIT 7"
    );
    $cat_labels=[]; $cat_totales=[];
    foreach($q_cat->fetchAll() as $r){ $cat_labels[]=$r['categoria_nombre']; $cat_totales[]=(int)$r['total']; }

    $q_recientes = $insLogin->ejecutarConsulta(
        "SELECT v.venta_id, v.venta_codigo, v.venta_fecha, v.venta_hora,
                v.venta_total, CONCAT(c.cliente_nombre,' ',c.cliente_apellido) AS cliente,
                CONCAT(u.usuario_nombre,' ',u.usuario_apellido) AS vendedor
         FROM venta v
         INNER JOIN cliente c ON v.cliente_id=c.cliente_id
         INNER JOIN usuario u ON v.usuario_id=u.usuario_id
         ORDER BY v.venta_id DESC LIMIT 6"
    );
    $ventas_recientes = $q_recientes->fetchAll();

    $q_stock = $insLogin->ejecutarConsulta(
        "SELECT producto_nombre, producto_codigo, producto_stock_total
         FROM producto WHERE producto_stock_total <= 10
         ORDER BY producto_stock_total ASC LIMIT 6"
    );
    $bajo_stock = $q_stock->fetchAll();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<div class="content-wrapper">

    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-breadcrumb"><i class="ri-home-4-line"></i> Panel principal</div>
            <div class="page-header-title">
                <div class="page-header-icon"><i class="ri-dashboard-line"></i></div>
                Dashboard
            </div>
        </div>
        <a href="<?php echo APP_URL; ?>saleNew/" class="button is-info is-rounded">
            <i class="ri-shopping-cart-2-line"></i> &nbsp; Nueva venta
        </a>
    </div>

    <p style="font-size:14px;color:var(--color-muted);margin-bottom:28px;">
        Bienvenido, <strong><?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?></strong>.
        Aquí tienes un resumen actualizado del sistema.
    </p>

    <!-- ── STAT CARDS ── -->
    <div class="columns is-multiline mb-2">

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>saleList/" class="stat-card" style="--stat-color:#4F46E5">
                <div class="stat-icon"><i class="ri-shopping-bag-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo number_format($total_ventas); ?></div>
                    <div class="stat-label">Ventas totales</div>
                </div>
            </a>
        </div>

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>saleList/" class="stat-card" style="--stat-color:#10B981">
                <div class="stat-icon"><i class="ri-money-dollar-circle-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo MONEDA_SIMBOLO.number_format($ingresos_total,2,',','.'); ?></div>
                    <div class="stat-label">Ingresos totales</div>
                </div>
            </a>
        </div>

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>saleList/" class="stat-card" style="--stat-color:#F59E0B">
                <div class="stat-icon"><i class="ri-calendar-check-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo MONEDA_SIMBOLO.number_format($ventas_hoy,2,',','.'); ?></div>
                    <div class="stat-label">Ventas hoy</div>
                </div>
            </a>
        </div>

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>productList/" class="stat-card" style="--stat-color:#8B5CF6">
                <div class="stat-icon"><i class="ri-box-3-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo number_format($total_productos); ?></div>
                    <div class="stat-label">Productos</div>
                </div>
            </a>
        </div>

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>clientList/" class="stat-card" style="--stat-color:#0EA5E9">
                <div class="stat-icon"><i class="ri-contacts-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo number_format($total_clientes); ?></div>
                    <div class="stat-label">Clientes</div>
                </div>
            </a>
        </div>

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>categoryList/" class="stat-card" style="--stat-color:#EF4444">
                <div class="stat-icon"><i class="ri-price-tag-3-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo number_format($total_categorias); ?></div>
                    <div class="stat-label">Categorías</div>
                </div>
            </a>
        </div>

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>userList/" class="stat-card" style="--stat-color:#06B6D4">
                <div class="stat-icon"><i class="ri-team-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo number_format($total_usuarios); ?></div>
                    <div class="stat-label">Usuarios</div>
                </div>
            </a>
        </div>

        <div class="column is-one-quarter-desktop is-half-tablet">
            <a href="<?php echo APP_URL; ?>cashierList/" class="stat-card" style="--stat-color:#64748B">
                <div class="stat-icon"><i class="ri-bank-card-line"></i></div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo number_format($total_cajas); ?></div>
                    <div class="stat-label">Cajas</div>
                </div>
            </a>
        </div>

    </div>

    <!-- ── CHARTS ROW ── -->
    <div class="columns mt-4">

        <!-- Ventas últimos 7 días -->
        <div class="column is-two-thirds">
            <div class="mv-card" style="height:320px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                    <p style="font-weight:700;font-size:14px;color:var(--color-text);display:flex;align-items:center;gap:8px;">
                        <i class="ri-line-chart-line" style="color:var(--color-primary);font-size:18px;"></i>
                        Ventas — últimos 7 días
                    </p>
                    <span style="font-size:12px;color:var(--color-muted);"><?php echo MONEDA_NOMBRE; ?></span>
                </div>
                <canvas id="chartVentas" style="max-height:240px;"></canvas>
            </div>
        </div>

        <!-- Productos por categoría -->
        <div class="column is-one-third">
            <div class="mv-card" style="height:320px;">
                <p style="font-weight:700;font-size:14px;color:var(--color-text);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <i class="ri-pie-chart-line" style="color:#8B5CF6;font-size:18px;"></i>
                    Productos por categoría
                </p>
                <div style="display:flex;align-items:center;justify-content:center;height:calc(100% - 48px);">
                    <canvas id="chartCategorias" style="max-height:220px;max-width:220px;"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- ── TABLES ROW ── -->
    <div class="columns">

        <!-- Ventas recientes -->
        <div class="column is-two-thirds">
            <div class="mv-card">
                <p style="font-weight:700;font-size:14px;color:var(--color-text);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <i class="ri-history-line" style="color:var(--color-info);font-size:18px;"></i>
                    Ventas recientes
                </p>
                <div class="table-container" style="box-shadow:none;border-radius:8px;">
                    <table class="table is-fullwidth is-hoverable" style="margin:0;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($ventas_recientes)>0): foreach($ventas_recientes as $v): ?>
                            <tr>
                                <td><?php echo $v['venta_id']; ?></td>
                                <td><code style="font-size:11px;background:#F1F5F9;padding:2px 6px;border-radius:4px;"><?php echo $v['venta_codigo']; ?></code></td>
                                <td><?php echo htmlspecialchars($v['cliente']); ?></td>
                                <td><?php echo htmlspecialchars($v['vendedor']); ?></td>
                                <td style="white-space:nowrap;"><?php echo date('d/m/Y',strtotime($v['venta_fecha'])); ?> <span style="color:var(--color-muted);font-size:11px;"><?php echo $v['venta_hora']; ?></span></td>
                                <td style="font-weight:600;color:var(--color-success);"><?php echo MONEDA_SIMBOLO.number_format($v['venta_total'],2,',','.'); ?></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="6" style="text-align:center;color:var(--color-muted);padding:32px;">Sin ventas registradas</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top:12px;text-align:right;">
                    <a href="<?php echo APP_URL; ?>saleList/" class="button is-link is-light is-small is-rounded">
                        Ver todas las ventas <i class="ri-arrow-right-line" style="margin-left:4px;"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bajo stock -->
        <div class="column is-one-third">
            <div class="mv-card">
                <p style="font-weight:700;font-size:14px;color:var(--color-text);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <i class="ri-alert-line" style="color:var(--color-danger);font-size:18px;"></i>
                    Productos con bajo stock
                </p>
                <?php if(count($bajo_stock)>0): foreach($bajo_stock as $p): ?>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--color-border);">
                    <div style="overflow:hidden;">
                        <div style="font-size:13px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;">
                            <?php echo htmlspecialchars($p['producto_nombre']); ?>
                        </div>
                        <div style="font-size:11px;color:var(--color-muted);"><?php echo $p['producto_codigo']; ?></div>
                    </div>
                    <?php
                        $stock = (int)$p['producto_stock_total'];
                        $color = $stock <= 3 ? 'var(--color-danger)' : ($stock <= 6 ? 'var(--color-warning)' : '#64748B');
                    ?>
                    <span style="font-size:14px;font-weight:700;color:<?php echo $color; ?>;background:<?php echo $stock<=3?'#FEE2E2':($stock<=6?'#FEF3C7':'#F1F5F9'); ?>;padding:2px 10px;border-radius:20px;white-space:nowrap;">
                        <?php echo $stock; ?> uds.
                    </span>
                </div>
                <?php endforeach; else: ?>
                <div style="text-align:center;color:var(--color-muted);padding:32px 0;">
                    <i class="ri-checkbox-circle-line" style="font-size:32px;color:var(--color-success);display:block;margin-bottom:8px;"></i>
                    Sin productos con bajo stock
                </div>
                <?php endif; ?>
                <div style="margin-top:12px;text-align:right;">
                    <a href="<?php echo APP_URL; ?>productList/" class="button is-danger is-light is-small is-rounded">
                        Ver inventario <i class="ri-arrow-right-line" style="margin-left:4px;"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
const chartColors = {
    indigo:  '#4F46E5',
    indigoLt:'rgba(79,70,229,.12)',
    purple:  '#8B5CF6',
    teal:    '#0EA5E9',
    green:   '#10B981',
    amber:   '#F59E0B',
    red:     '#EF4444',
    slate:   '#64748B',
    pink:    '#EC4899',
};

const palette = [chartColors.indigo, chartColors.purple, chartColors.teal,
                 chartColors.green, chartColors.amber, chartColors.red, chartColors.pink];

Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.font.size   = 12;
Chart.defaults.color       = '#64748B';

/* ── Ventas últimos 7 días ── */
new Chart(document.getElementById('chartVentas'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($semana_labels); ?>,
        datasets: [{
            label: 'Ventas (<?php echo MONEDA_SIMBOLO; ?>)',
            data: <?php echo json_encode($semana_totales); ?>,
            borderColor: chartColors.indigo,
            backgroundColor: chartColors.indigoLt,
            borderWidth: 2.5,
            pointBackgroundColor: chartColors.indigo,
            pointRadius: 4,
            pointHoverRadius: 6,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1E293B',
                titleColor: '#F1F5F9',
                bodyColor: '#94A3B8',
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => ' <?php echo MONEDA_SIMBOLO; ?>' + ctx.parsed.y.toFixed(2)
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: { color: '#94A3B8' }
            },
            y: {
                grid: { color: 'rgba(0,0,0,.05)', drawBorder: false },
                border: { display: false },
                beginAtZero: true,
                ticks: {
                    color: '#94A3B8',
                    callback: v => '<?php echo MONEDA_SIMBOLO; ?>' + v.toFixed(0)
                }
            }
        }
    }
});

/* ── Productos por categoría ── */
new Chart(document.getElementById('chartCategorias'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($cat_labels); ?>,
        datasets: [{
            data: <?php echo json_encode($cat_totales); ?>,
            backgroundColor: palette,
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 12,
                    boxWidth: 10,
                    usePointStyle: true,
                    pointStyleWidth: 10,
                    color: '#64748B',
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: '#1E293B',
                titleColor: '#F1F5F9',
                bodyColor: '#94A3B8',
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' productos'
                }
            }
        }
    }
});
</script>
