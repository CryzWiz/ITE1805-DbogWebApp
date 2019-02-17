/**
 * Created by Chexxor on 4/24/2017.
 */
function parseInput(/*string*/content){
    if(typeof content === 'string'){
        content = replaceLineBreaks(content);
        content = replaceStyleTags(content);
    }
    return content;
}

function replaceLineBreaks(/*string*/content){
    if(typeof content === 'string') {
        /*while(content.indexOf("\n\n") !== -1) { // TODO implement double linebreak => new paragraph
            content = content.replace("\n\n", '</p><p>');
        }*/
        while(content.indexOf('\n') !== -1) {
            content = content.replace('\n', "<br>");
        }
    }
    return content;
}

function replaceStyleTags(/*string*/content) {
    var regex = /\[\/?[buiBUI]]/g;
    var stack = [];
    var stackPos = [];
    var match;
    while((match = regex.exec(content)) !== null){
        var matchStr = "" + match;
        if(matchStr.charAt(1) === '/'){
            if(matchStr.charAt(2) === stack.pop()){
                var startPos = stackPos.pop();
                content = content.substr(0, startPos) + "<" + matchStr.charAt(2) + ">" + content.substr(startPos+3);
                content = content.substr(0, match.index) + "</" + matchStr.charAt(2) + ">" + content.substr(match.index+4);
            } else {
                alert("Error in style tag syntax. Make sure any style tags are nested in the right order and that innermost tags are closed before outer tags are.");
                break;
            }
        } else {
            stack.push(matchStr.charAt(1));
            stackPos.push(match.index);
        }
    }
    return content;
}
