<!DOCTYPE html>
<html>

<head>
    <title>Gitee on keyboard</title>
    <meta charset="UTF-8">
    <meta content='' name='Keywords'>
    <meta content='' itemprop='description' name='Description'>
    <link rel="stylesheet" href="/static/css/element.css">
    <style>
        body,
        html {
            padding: 0;
            margin: 0;
            background-color: #f5f5f5;
        }

        * {
            font-family: consolas, PingFang SC, Microsoft YaHei;
        }

        [v-cloak] {
            visibility: hidden !important;
        }

        textarea {
            resize: none !important;
        }

        pre {
            overflow: auto;
        }

        pre>* {
            font-size: 14px;
            margin: 0;
        }

        .header {
            margin-bottom: 10px;
            height: 70px !important;
        }

        .key {
            color: #333;
        }

        .hljs-string {
            color: green !important;
        }

        .hljs-number {
            color: orangered !important;
        }

        .hljs-literal {
            color: red !important;
        }

        .hljs {
            background-color: white !important;
        }

        ::-webkit-scrollbar {
            width: 0px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background-color: rgba(50, 50, 50, 0.1);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.2);
        }

        ::-webkit-scrollbar-button {
            background-color: transparent;
        }

        ::-webkit-scrollbar-corner {
            background: transparent;
        }

        .repos {
            overflow: hidden;
        }

        .repos .item {
            width: 20%;
            display: inline-block;
        }

        .repos .card {
            background-color: #fff;
            height: 120px;
            border: 5px solid #f5f5f5;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            padding: 10px 15px;
            position: relative;
        }

        .repos .active {
            border: 5px solid rgba(255, 100, 0, 0.5)
        }

        .repos .title {
            font-size: 20px;
            color: #333;
            font-weight: bold;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .repos .desc {
            font-size: 14px;
            color: #999;
            margin-top: 10px;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
        }

        .repos .info {
            position: absolute;
            left: 10px;
            bottom: 10px;
        }

        .repos .info .detail {
            display: table-cell;
        }

        .repos .key {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
            font-size: 12px;
            border: 1px solid #666;
            background-color: #666;
            color: white;
            padding: 1px 3px;
            border-right: none;
        }

        .repos .value {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
            font-size: 12px;
            border: 1px solid #ccc;
            border-left: none;
            color: #666;
            padding: 1px 3px;
        }

        .repos .badge {
            border-radius: 3px;
            font-size: 12px;
            border: 1px solid #ccc;
            color: #666;
            padding: 1px 3px;
        }

        .search {
            text-align: center;
            padding-top: 200px;
            z-index: 99;
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: #f5f5f5;
        }

        .search .form {
            width: 800px;
        }

        .search .logo {
            text-align: center;
            display: block;
        }

        .repo_detail {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: #f5f5f5;
            padding: 20px 40px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .repo_detail .name {
            font-size: 28px;
            color: #333;
            font-weight: bold;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            display: inline-block;
        }

        .repo_detail .name .badge {
            margin-left: 10px;
        }

        .repo_detail .name .badge span {
            margin-right: 3px;
            font-weight: normal;
            float: left;
        }

        .repo_detail .right-info {
            float: right;
        }

        .repo_detail .right-info span {
            font-size: 14px;
        }

        .repo_detail .desc {
            font-size: 16px;
            color: #999;
            margin-top: 30px;
        }

        .repo_detail .readme img {
            max-width: 100%;
        }

        .tips {
            margin-top: 200px;
            text-align: center;
        }

        .tips img {
            width: 600px;
        }

        .tips .text {
            font-size: 20px;
            color: #999;
        }
    </style>
</head>

<body>
    <div id="app" v-cloak>
        <div class="search" v-if="config.searching">
            <div class="logo"><img src="/static/gitee.png" /></div>
            <el-input autoFocus="true" id="keyword" ref="keyword" v-model="config.keyword"
                placeholder="Tell me what you want..." class="form" size="large">
                <el-button slot="append" icon="el-icon-search" @click="doSearch">Gitee Search</el-button>
            </el-input>
        </div>
        <div class="repos">
            <el-row v-if="repos.length>0">
                <el-col class="item" :span="4" v-for="(item,index) in repos" :id="['repo_'+index]">
                    <div :class="[config.repoSelectedIndex==index?'active card':'card']"
                        @click="config.repoSelectedIndex = index;showDetail()">
                        <div class="title">{{item.human_name}}</div>
                        <div class="desc">{{item.description}}</div>
                        <div class="info">
                            <span class="detail"><span class="key">Star</span><span
                                    class="value">{{item.stargazers_count}}</span></span>
                            <span class="detail" v-if="item.license"><span class="badge">{{item.license}}</span></span>
                            <span class="detail" v-if="item.language"><span
                                    class="badge">{{item.language}}</span></span>
                        </div>
                    </div>
                </el-col>
            </el-row>
            <div v-if="repos.length==0" class="tips">
                <img src="/static/gitee.png" />
                <div class="text">
                    Nothing Found!
                </div>
            </div>
        </div>
        <div id="repo_detail" class="repo_detail" v-if="config.showRepoDetail">
            <div class="name">
                {{repo.human_name}}
            </div>
            <div class="right-info">
                <el-tag effect="dark" type="danger">{{repo.stargazers_count}} Stars</el-tag>
                <el-tag effect="dark" type="warning">{{repo.watchers_count}} Watches</el-tag>
            </div>
            <div class="info">
                <span class="badge">
                    <el-tag size="mini" effect="dark" type="info" v-if="repo.license">{{repo.license}}</el-tag>
                    <el-tag size="mini" effect="dark" type="info" v-if="repo.language">{{repo.language}}</el-tag>
                </span>
            </div>
            <div class="desc">{{repo.description}}</div>
            <div class="readme" v-html="readme"></div>
        </div>
    </div>
</body>
<script src="/static/js/vue-2.6.10.min.js"></script>
<script src="/static/js/axios.min.js"></script>
<script src="/static/js/element.js"></script>
<link rel="stylesheet" href="/static/css/highlight.min.css">
<script src="/static/js/highlight.min.js"></script>
<script type="text/javascript" src='https://cdn.jsdelivr.net/npm/marked/marked.min.js'></script>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                config: {
                    api: "https://gitee_proxy.hamm.cn/",
                    searching: true,
                    keyword: "",
                    page: 1,
                    repoSelectedIndex: 0,
                    isLoadingData: false,
                    ctrl: false,
                    alt: false,
                    showRepoDetail: false,
                },
                repos: [],
                repo: {},
                readme: "加载中"
            }
        },
        created() {
            var that = this;
            document.onkeydown = function (event) {
                var e = event || window.event || arguments.callee.caller.arguments[0];
                var EventStop = true;
                if (that.config.isLoadingData) {
                    e.preventDefault();
                    return;
                }
                switch (e.keyCode) {
                    case 17:
                        that.config.ctrl = true;
                        break;
                    case 18:
                        that.config.alt = true;
                        break;
                    case 37:
                        var index = that.config.repoSelectedIndex - 1;
                        index = index >= 0 ? index : 0;
                        that.config.repoSelectedIndex = index;
                        that.$nextTick(function () {
                            document.getElementById('repo_' + index).scrollIntoViewIfNeeded();
                        });
                        break;
                    case 38:
                        if (that.config.showRepoDetail) {
                            var value = document.getElementById('repo_detail').scrollTop - 100;
                            document.getElementById('repo_detail').scrollTop = value > 0 ? value : 0;
                        } else {
                            var index = that.config.repoSelectedIndex - 5;
                            index = index >= 0 ? index : 0;
                            that.config.repoSelectedIndex = index;
                            that.$nextTick(function () {
                                document.getElementById('repo_' + index).scrollIntoViewIfNeeded();
                            });
                        }
                        break;
                    case 39:
                        var index = that.config.repoSelectedIndex + 1;
                        index = index <= that.repos.length - 1 ? index : that.repos.length - 1;
                        that.config.repoSelectedIndex = index;
                        that.$nextTick(function () {
                            document.getElementById('repo_' + index).scrollIntoViewIfNeeded();
                        });
                        if (that.config.repoSelectedIndex > that.repos.length - 5) {
                            that.config.page++;
                            that.doSearch();
                        }
                        break;
                    case 40:
                        if (that.config.showRepoDetail) {
                            var value = document.getElementById('repo_detail').scrollTop + 100;
                            document.getElementById('repo_detail').scrollTop = value > 0 ? value : 0;
                        } else {
                            var index = that.config.repoSelectedIndex + 5;
                            index = index <= that.repos.length - 1 ? index : that.repos.length - 1;
                            that.config.repoSelectedIndex = index;
                            that.$nextTick(function () {
                                document.getElementById('repo_' + index).scrollIntoViewIfNeeded();
                            });
                            if (that.config.repoSelectedIndex > that.repos.length - 5) {
                                that.config.page++;
                                that.doSearch();
                            }
                        }
                        break;
                    case 27:
                        if (that.config.showRepoDetail) {
                            that.config.showRepoDetail = false;
                        } else {
                            if (!that.config.searching) {
                                that.config.searching = true;
                                that.$nextTick(function () {
                                    //set focus when show the search box
                                    that.config.keyword = '';
                                    that.$refs['keyword'].focus();
                                });
                            }
                        }
                        break;
                    case 112:
                        that.$message({
                            dangerouslyUseHTMLString: true,
                            type: '',
                            message: `<div style="font-size:20px;color:#333;">
                                <div>ESC   :         Go back</div>
                                <div>F1    :         Get helps</div>
                                <div>F3    :         Search projects</div>
                                <div>Enter :         Search projects</div>
                            </div>`
                        });
                        break;
                    case 114:
                        //F3 to show or hide the search box
                        that.config.searching = !that.config.searching;
                        if (that.config.searching || that.repos.length == 0) {
                            that.config.searching = true;
                            that.$nextTick(function () {
                                //set focus when show the search box
                                that.config.keyword = '';
                                that.$refs['keyword'].focus();
                            });
                        }
                        break;
                    case 13:
                        //Enter
                        if (that.config.searching) {
                            //search
                            if (that.config.keyword) {
                                that.config.page = 1;
                                that.config.repoSelectedIndex = 0;
                                that.doSearch();
                            }
                        } else {
                            if (that.config.showRepoDetail) {

                            } else {
                                that.showDetail();
                            }
                        }
                        break;
                    case 122:
                        EventStop = false;
                        break;
                    default:
                        if (that.config.searching) {
                            EventStop = false;
                        }
                }
                if (EventStop) {
                    e.preventDefault();
                }
            };
            document.onkeyup = function (event) {
                var e = event || window.event || arguments.callee.caller.arguments[0];
                switch (e.keyCode) {
                    case 17:
                        that.config.ctrl = false;
                        break;
                    case 18:
                        that.config.alt = false;
                        break;
                    default:
                }
            };
        },
        updated() { },
        methods: {
            showDetail() {
                var that = this;
                if (that.config.repoSelectedIndex >= 0 && that.repos.length > 0) {
                    //Get repo information from gitee
                    if (that.config.isLoadingData) {
                        return;
                    }
                    that.config.isLoadingData = true;
                    const loading = that.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    axios.get(that.config.api + 'api/v5/repos/' + that.repos[that.config.repoSelectedIndex].full_name, {})
                        .then(function (response) {
                            loading.close();
                            that.config.searching = false;
                            that.config.isLoadingData = false;
                            that.config.showRepoDetail = true;
                            if (response.data.hasOwnProperty("message")) {
                                that.$message.error(response.data.msg);
                            } else {
                                that.repo = response.data;
                                axios.get(that.config.api + 'api/v5/repos/' + that.repos[that.config.repoSelectedIndex].full_name + "/readme", {})
                                    .then(function (response) {
                                        if (response.data.hasOwnProperty("message")) {
                                            that.$message.error(response.data.msg);
                                        } else {
                                            that.readme = marked(base64_decode(response.data.content));
                                            console.log(that.readme);
                                        }
                                    }).
                                    catch(function (error) {
                                        console.log(error)
                                        that.$message.error('出现异常，你可以控制台查看错误');
                                    });
                            }
                        }).
                        catch(function (error) {
                            console.log(error)
                            that.$message.error('出现异常，你可以控制台查看错误');
                        });
                }
            },
            doSearch() {
                var that = this;
                if (that.config.isLoadingData || !that.config.keyword) {
                    that.$nextTick(function () {
                        //set focus when show the search box
                        that.config.keyword = '';
                        that.$refs['keyword'].focus();
                    });
                    return;
                }
                that.config.isLoadingData = true;
                const loading = that.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                axios.get(that.config.api + 'api/v5/search/repositories?page=' + that.config.page + '&per_page=50&q=' + that.config.keyword, {})
                    .then(function (response) {
                        loading.close();
                        that.config.searching = false;
                        that.config.isLoadingData = false;
                        if (response.data.hasOwnProperty("message")) {
                            that.$message.error(response.data.msg);
                        } else {
                            if (that.config.page == 1) {
                                that.repos = [];
                            }
                            for (var i = 0; i < response.data.length; i++) {
                                that.repos.push(response.data[i]);
                            }
                        }
                    }).
                    catch(function (error) {
                        console.log(error)
                        that.$message.error('出现异常，你可以控制台查看错误');
                    });
            },
            onSubmit() {
                var that = this;
                axios.post('api.php', {})
                    .then(function (response) {
                        if (response.data.code == 200) {
                            that.$message({
                                message: '请求成功',
                                type: 'success'
                            });
                        } else {
                            that.$message.error(response.data.msg);
                        }
                    })
                    .
                    catch(function (error) {
                        console.log(error)
                        that.$message.error('出现异常，你可以控制台查看错误');
                    });
            },
        }
    });
    /*
  *  base64编码(编码，配合encodeURIComponent使用)
  *  @parm : str 传入的字符串
  *  使用：
        1、引入util.js(路径更改) :const util  = require('../../utils/util.js');
        2、util.base64_encode(util.utf16to8('base64 编码'));
 */
    function base64_encode(str) {
        //下面是64个基本的编码
        var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
        var out, i, len;
        var c1, c2, c3;
        len = str.length;
        i = 0;
        out = "";
        while (i < len) {
            c1 = str.charCodeAt(i++) & 0xff;
            if (i == len) {
                out += base64EncodeChars.charAt(c1 >> 2);
                out += base64EncodeChars.charAt((c1 & 0x3) << 4);
                out += "==";
                break;
            }
            c2 = str.charCodeAt(i++);
            if (i == len) {
                out += base64EncodeChars.charAt(c1 >> 2);
                out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
                out += base64EncodeChars.charAt((c2 & 0xF) << 2);
                out += "=";
                break;
            }
            c3 = str.charCodeAt(i++);
            out += base64EncodeChars.charAt(c1 >> 2);
            out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
            out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
            out += base64EncodeChars.charAt(c3 & 0x3F);
        }
        return out;
    }
    /*
      *  base64编码(编码，配合encodeURIComponent使用)
      *  @parm : str 传入的字符串
     */
    function utf16to8(str) {
        var out, i, len, c;
        out = "";
        len = str.length;
        for (i = 0; i < len; i++) {
            c = str.charCodeAt(i);
            if ((c >= 0x0001) && (c <= 0x007F)) {
                out += str.charAt(i);
            } else if (c > 0x07FF) {
                out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
                out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
            } else {
                out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
            }
        }
        return out;
    }

    function base64_decode(input) {
        var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while (i < input.length) {
            enc1 = base64EncodeChars.indexOf(input.charAt(i++));
            enc2 = base64EncodeChars.indexOf(input.charAt(i++));
            enc3 = base64EncodeChars.indexOf(input.charAt(i++));
            enc4 = base64EncodeChars.indexOf(input.charAt(i++));
            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;
            output = output + String.fromCharCode(chr1);
            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
        }
        return utf8_decode(output);
    }

    function utf8_decode(utftext) {
        var string = '';
        let i = 0;
        let c = 0;
        let c1 = 0;
        let c2 = 0;
        while (i < utftext.length) {
            c = utftext.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else if ((c > 191) && (c < 224)) {
                c1 = utftext.charCodeAt(i + 1);
                string += String.fromCharCode(((c & 31) << 6) | (c1 & 63));
                i += 2;
            } else {
                c1 = utftext.charCodeAt(i + 1);
                c2 = utftext.charCodeAt(i + 2);
                string += String.fromCharCode(((c & 15) << 12) | ((c1 & 63) << 6) | (c2 & 63));
                i += 3;
            }
        }
        return string;
    }

</script>

</html>