var RColor=function(){this.hue=Math.random(),this.goldenRatio=.618033988749895};RColor.prototype.hsvToRgb=function(t,a,r){var e=Math.floor(6*t),i=6*t-e,o=r*(1-a),l=r*(1-i*a),s=r*(1-(1-i)*a),h=255,n=255,d=255;switch(e){case 0:h=r,n=s,d=o;break;case 1:h=l,n=r,d=o;break;case 2:h=o,n=r,d=s;break;case 3:h=o,n=l,d=r;break;case 4:h=s,n=o,d=r;break;case 5:h=r,n=o,d=l}return[Math.floor(256*h),Math.floor(256*n),Math.floor(256*d)]},RColor.prototype.get=function(t,a,r){this.hue+=this.goldenRatio,this.hue%=1,"number"!=typeof a&&(a=.5),"number"!=typeof r&&(r=.95);var e=this.hsvToRgb(this.hue,a,r);return t?"#"+e[0].toString(16)+e[1].toString(16)+e[2].toString(16):e};var WysijaCharts={charts:[],chartsCount:0,current:null,getData:function(t){return void 0===t?!1:(jQuery.get(t,function(t){return t.result.success===!0&&t.result.data?(this.current.dataProvider=t.result.data,this.current.validateData(),!0):void 0}.bind(this)),!1)},createChart:function(t,a){var r=null;switch(a.type){case"piechart":r=new AmCharts.AmPieChart,r.titleField=a.titleField,r.color="#333333",r.fontSize=12,r.valueField=a.valueField,r.sequencedAnimation=!0,r.startEffect="elastic",r.innerRadius="30%",r.startDuration=0,r.labelRadius=15,void 0!==a.threeD&&(r.depth3D=10,r.angle=15);break;case"column":r=new AmCharts.AmSerialChart,r.categoryField=a.categoryField,r.color="#333333",r.fontSize=12,r.startDuration=0,r.plotAreaFillAlphas=.2,void 0!==a.threeD&&(r.angle=30,r.depth3D=60);var e=r.categoryAxis;e.gridAlpha=.2,e.gridPosition="start",e.gridColor="#AAAAAA",e.axisColor="#AAAAAA",e.axisAlpha=.5,e.dashLength=5;var i=new AmCharts.ValueAxis;if(i.gridAlpha=.2,i.gridColor="#AAAAAA",i.axisColor="#AAAAAA",i.axisAlpha=.5,i.dashLength=5,i.title="Orders",i.titleColor="#999999",r.addValueAxis(i),void 0!==a.graphs){var o=a.graphs,l=null;new RColor;for(var s=0,h=o.length;h>s;s++)l=new AmCharts.AmGraph,l.title=o[s].title,l.valueField=o[s].valueField,l.type="column",l.lineAlpha=1,l.lineColor=o[s].color,l.fillAlphas=.6,l.balloonText="[[value]]",r.addGraph(l),l=null;var n=new AmCharts.ChartCursor;n.zoomable=!1,n.cursorAlpha=0,r.addChartCursor(n);var d=new AmCharts.AmLegend;r.addLegend(d)}}if(void 0!==a.title&&r.addTitle(a.title),void 0!==a.data)r.dataProvider=a.data,r.validateData();else{if(void 0===a.url)return alert("missing data provider"),!1;this.getData(a.url,function(t){r.dataProvider=t}.bind(r))}this.chartsCount=this.charts.push(r),this.charts[this.chartsCount-1].elementId=t,this.current=this.charts[this.chartsCount-1],this.current.write(this.current.elementId)}};