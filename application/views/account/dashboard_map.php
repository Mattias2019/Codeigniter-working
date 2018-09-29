<h2 class="worldmap-header"><?= t('YOUR GLOBAL PROJECT MAP');?></h2>
<div id="worldmap-legend" class="worldmap-legend"></div>
<div class="worldmap-wrapper">
    <div id="worldmap" class="worldmap"></div>
</div>

<style>
    .worldmap-wrapper {
        position: relative;
        padding-bottom: 50%;
    }
    .worldmap {
        position: absolute;
        width: 100%;
        height: 100%;
    }
    .worldmap-header {
        position: absolute;
        top: -10px;
    }
    .worldmap-legend {
        width: 100%;
        height: 40px;
    }
    .worldmap-project-header {
        color: #1e88e5;
        font-weight: bold;
    }
    .ammapDescriptionTitle, .ammapDescriptionText {
        font-family: Lato, sans-serif;
        font-size: 16px;
    }
    .ammapDescriptionTitle {
        color: #1e88e5;
    }
</style>

<script>
    function makeMap() {
        var map = AmCharts.makeChart("worldmap", {
            "type": "map",
            "projection": "miller",
            "addClassNames": true,
            "dragMap": false,
            "fontFamily": "Lato, sans-serif",
            "fontSize": 16,
            "zoomOnDoubleClick": false,
            "areasSettings": {
                "balloonText": "",
                "color": "#404451",
                "outlineColor": "#404451",
                "rollOverOutlineColor": undefined
            },
            "balloon": {
                "borderThickness": 0,
                "fillAlpha": 1,
                "textAlign": "left"
            },
            "imagesSettings": {
                "balloonText": "<h4 class='worldmap-project-header'>[[title]]</h4><p>[[description]]</p>"
            },
            "legend": {
                "align": "right",
                "divId": "worldmap-legend",
                "equalWidths": false,
                "data": [
                    {
                        "title": "Active",
                        "color": "#1e88e5",
                        "markerType": "circle"
                    },
                    {
                        "title": "Past",
                        "color": "#bdbdbd",
                        "markerType": "circle"
                    },
                    {
                        "title": "Future",
                        "color": "#83c145",
                        "markerType": "circle"
                    }
                ]
            },
            "zoomControl": {
                "homeButtonEnabled": false,
                "zoomControlEnabled": false
            },
            "dataProvider": {
                "map": "worldLow",
                "getAreasFromMap": true,
                "images": <?php echo $this->outputData['map_projects']; ?>
            }
        });
    }
</script>