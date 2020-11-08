<%@page import="java.util.Enumeration"%>
<%@page import="me.sort.sortbook.Usuario"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%
    if (request.getSession().getAttribute("user") == null || ((Usuario) request.getSession().getAttribute("user")) == null || ((Usuario) request.getSession().getAttribute("user")).getNombre() == null) {
        //Mandamos al login, pero con los parámetros de redirect de forma escondida (Método POST)
        out.print(getRedirectFormHTML(request));
        response.flushBuffer();
        return;
    }
%>
<%!
    private String getRedirectFormHTML(HttpServletRequest request) {
        String referer = "";
        try {
            referer = request.getHeader("Referer") != null ? request.getHeader("Referer") : "";
        } catch (Exception e){}
        StringBuilder html = new StringBuilder();
        StringBuilder params = new StringBuilder(referer.contains("?") ? "&" : "?");
        Enumeration enumParamName = request.getParameterNames();
        /**
         * Crearemos el form con el parámetro "url_redirect_hidden" para darle
         * un redirect en modo POST para que no sea visible a la hora de
         * loguearse.
         */
        html.append("<form action='").append(request.getContextPath()).append("/login.jsp").append("' id='form' method='post' style='display:none;'>");
        while (enumParamName.hasMoreElements()) {
            String paramName = (String) enumParamName.nextElement();
            String value = request.getParameterValues(paramName)[0];
            
            if (!value.equals("")) params.append(paramName).append("=").append(value).append("&");
        }
        
        if (referer.equals("")) {
            html.append("   <input type='hidden' name='url_redirect_hidden' value='").append(request.getRequestURI()).append(params).append("'>");
        } else {
            html.append("   <input type='hidden' name='url_redirect_hidden' value='").append(referer).append(params).append("'>");
        }
        
        html.append("</form>");
        /**
         * Ejecutaremos el JS que dará submit al form que da re-dirección al
         * login.jsp con los parámetros por POST. Es la forma de redirigir a
         * otra página con parámetros POST. Antes se hacía
         * response.sendRedirect(... pero es por GET
         */
        html.append("<script>document.getElementById('form').submit();</script>");
        return html.toString();
    }
%>