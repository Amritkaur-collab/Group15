const canvas = document.getElementById('myCanvas');
const ctx = canvas.getContext("2d");


var p = Array( 10, 160, 180, 140, 40, 120, 53, 100, 45, 80, 200, 40);


drawLineGraph(p);

function lineGraphScale(points)
{
    var lowest = points[0];
    var highest = points[0];

    for(let i = 1; i < points.length; i++)
        {
            if(points[i] > highest)
            {
                highest = points[i];
            }
            if(points[i] < lowest)
            {
                lowest = points[i];
            }
        }

    return Array(lowest, highest);
}

function drawLineGraph(points)
{
    var spacing = (canvas.width-30) / (points.length-1);
    var pxscale = (canvas.height-30) / 100; 
    var scale = lineGraphScale(points);

    ctx.beginPath();
    ctx.moveTo(15, canvas.height-15); 
    ctx.lineTo(canvas.width-15, canvas.height-15);

    ctx.moveTo(15, 15); 
    ctx.lineTo(15, canvas.height-15);

    ctx.moveTo(15, 15); 
    ctx.lineTo(canvas.width-15, 15);

    ctx.moveTo(canvas.width-15, 15); 
    ctx.lineTo(canvas.width-15, canvas.height-15);

    for(let i = 0; i < 7; i++)
    {
        ctx.moveTo(15, canvas.height-15-((canvas.height-30)/7)*i); 
        ctx.lineTo(canvas.width-15, canvas.height-15-((canvas.height-30)/7)*i);
    }

    ctx.stroke();


    
    for(let i = 0; i < points.length; i++)
    {
        ctx.beginPath();
        ctx.strokeStyle = 'black';
        ctx.arc(15+spacing*i, canvas.height-15 - ((points[i] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale), 2, 0, 2 * Math.PI);
        ctx.fill();
        ctx.moveTo(15+spacing*i, 15); 
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(15+spacing*i, 15); 
        ctx.strokeStyle = 'lightgrey';
        ctx.lineTo(15+spacing*i, canvas.height-15);
        ctx.stroke();

        ctx.beginPath();
        ctx.strokeStyle = 'black';
        ctx.font = "11px Arial";
        ctx.fillText((points[i]),2.5+spacing*i, canvas.height-17.5 - ((points[i] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale));
        ctx.stroke();

    }

    p1 = canvas.height -15 - (points[0] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale;
    ctx.beginPath();
    ctx.lineWidth = 1.5;
    ctx.moveTo(15, p1); 
    for(let i = 1; i < points.length; i++)
    {
        ctx.strokeStyle = 'blue';
        ctx.lineTo(15+spacing*i, canvas.height-15 - ((points[i] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale));
    }
    ctx.stroke();
}


