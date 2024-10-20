



function lineGraphScale(points)
{
    var lowest = points[0][1];
    var highest = points[0][1];

    for(let i = 1; i < points.length; i++)
        {
            if(points[i][1] > highest)
            {
                highest = points[i][1];
            }
            if(points[i][1] < lowest)
            {
                lowest = points[i][1];
            }
        }

    return Array(lowest, highest);
}

export function drawLineGraph(points, canvasId, color)
{
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");

    if(points.length <= 0 || isNaN(points[0][1]))
    {
        ctx.fillStyle = 'black';
        ctx.font = "20px Arial";
        ctx.textAlign = "center";
        ctx.fillText("DATA NOT FOUND", canvas.width/2, canvas.height/2);
        return;
    }

    var scale = lineGraphScale(points);
    var padding_top = 20;
    var padding_bottom = 70;
    var padding_side = 20;

    var originW = canvas.width-padding_side;
    var originH = canvas.height-padding_bottom;

    var height = canvas.height - padding_bottom - padding_top;
    var width = canvas.width - (padding_side*4);

    var spacing = (width) / (points.length-1);
    var pxscale = (height) / 100; 

    var segments = 4;
    ctx.fillStyle = 'black';
    ctx.font = "11px Arial";

    for(let i = 0; i < segments; i++)
    {
        // Horizonal lines
        ctx.beginPath();
        ctx.lineWidth = 1.5;
        ctx.strokeStyle = 'grey';
        ctx.moveTo(padding_side+15, originH-((originH-padding_top)/segments)*i); 
        ctx.lineTo(originW-15, originH-((originH-padding_top)/segments)*i);
        ctx.stroke();

        // Y Values
        ctx.fillStyle = 'black';
        ctx.fillText(parseFloat((scale[0]+i*((scale[1]-scale[0])/segments)).toFixed(1)),originW-13, originH+2.5-((originH-padding_top)/segments)*i);
    }
    ctx.fillText(parseFloat(scale[1].toFixed(1)), originW-13, padding_top+2.5);

    for(let i = 0; i < points.length-1; i++)
    {
        // Vertical Lines
        ctx.beginPath();
        ctx.lineWidth = 1.5;
        ctx.moveTo(padding_side*2+spacing*i, padding_top); 
        ctx.strokeStyle = 'lightgrey';
        ctx.lineTo(padding_side*2+spacing*i, originH+5);
        ctx.stroke();

        // Graph
        ctx.beginPath();
        ctx.strokeStyle = color;
        ctx.moveTo(padding_side*2+spacing*(i), originH - ((points[i][1] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale)); 
        ctx.lineTo(padding_side*2+spacing*(i+1), originH - ((points[i+1][1] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale));
        ctx.stroke();

        // Points
        ctx.beginPath();
        ctx.strokeStyle = 'black';
        ctx.arc(padding_side*2+spacing*(i), originH - ((points[i][1] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale), 2, 0, 2 * Math.PI);
        ctx.fill();
        ctx.stroke();

        // X Values
        ctx.beginPath();
        ctx.fillStyle = 'black';
        ctx.textAlign = "center";
        ctx.fillText(points[i][0], padding_side*2+spacing*i, originH+15);
        ctx.stroke();
    }

    ctx.beginPath();
    ctx.fillStyle = 'black';
    ctx.textAlign = "center";
    ctx.fillText(points[points.length-1][0], padding_side*2+spacing*(points.length-1), originH+15);
    ctx.stroke();

    ctx.beginPath();
    ctx.strokeStyle = 'black';
    ctx.arc(padding_side*2+spacing*(points.length-1), originH - ((points[points.length-1][1] - scale[0]) * (100/(scale[1] - scale[0])) * pxscale), 2, 0, 2 * Math.PI);
    ctx.fill();
    ctx.stroke();


    // Outer Box
    ctx.beginPath();
    ctx.strokeStyle = 'black';
    ctx.moveTo(padding_side+15, originH); 
    ctx.lineTo(originW-15, originH);

    ctx.moveTo(padding_side+20, padding_top); 
    ctx.lineTo(padding_side+20, originH+5);

    ctx.moveTo(padding_side+15, padding_top); 
    ctx.lineTo(originW-15, padding_top);

    ctx.moveTo(originW-20, padding_top); 
    ctx.lineTo(originW-20, originH+5);

    ctx.stroke();
}


