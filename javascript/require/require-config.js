/**
 * 1. 使用require进行加载， 防止加载JS过程中，组织页面渲染
 * 2. config.paths， 配置时不能写后缀
 *      以数组的形式，表示第一个加载失败，就加载第二个。线上jquery加载失败，就加载本地jQuery库
 *
 *  packages.location是相对于baseURL的路径
 */

require.config({
    // baseUrl: "",
    // packages: [
    //     {
    //         name: "lib", location: "../../../html/lib", main: "lib"
    //     }
    // ],
    paths: {
        // "jquery": ["https://cdn.staticfile.org/jquery/1.10.2/jquery.min", '../../html/lib/jquery-2.1.1.min'],
        "jquery" : "../../html/lib/jquery-1.8.3",
        "respond": "../../html/lib/respond/respond.min",
        "myframe": "./Myframe"
    }
});