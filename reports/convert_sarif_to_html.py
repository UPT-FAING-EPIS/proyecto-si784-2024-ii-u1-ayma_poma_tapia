import json

def sarif_to_html(sarif_file, output_file):
    with open(sarif_file, 'r') as f:
        sarif_data = json.load(f)

    findings = []

    # Extraer hallazgos
    for run in sarif_data.get("runs", []):
        for result in run.get("results", []):
            rule_id = result.get("ruleId", "Unknown Rule")
            message = result.get("message", {}).get("text", "No message")
            for location in result.get("locations", []):
                file_path = location.get("physicalLocation", {}).get("artifactLocation", {}).get("uri", "Unknown File")
                start_line = location.get("physicalLocation", {}).get("region", {}).get("startLine", "Unknown Line")
                findings.append((rule_id, message, file_path, start_line))

    # Crear el archivo HTML
    with open(output_file, 'w') as f:
        f.write("<html><head><style>\n")
        f.write("body {font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 20px;}\n")  # Fondo claro
        f.write("h1 {color: #6dd6a3; text-align: center;}\n")  # Verde
        f.write("h2 {color: #8b5bca; border-bottom: 1px solid #ddd; padding-bottom: 5px; text-align: center;}\n")  # Morado
        f.write("p {background-color: #fff; padding: 10px; border-radius: 5px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); margin-bottom: 10px;}\n")
        f.write(".logo {text-align: center; margin: 20px;}\n")
        f.write("</style></head><body>\n")
        
        # Logotipo de Semgrep (usando imagen local)
        f.write("<div class='logo'><img src='semgrep-logo.png' alt='Semgrep Logo' width='150'></div>\n")  # Asegúrate de que el nombre y la extensión sean correctos
        
        f.write("<h1>Reporte de Semgrep</h1>\n")
        f.write(f"<h2>Total de problemas encontrados: {len(findings)}</h2>\n")

        # Detallar hallazgos
        if findings:
            for rule_id, message, file_path, start_line in findings:
                f.write(f"<p><b>Regla:</b> {rule_id}<br>\n")
                f.write(f"<b>Mensaje:</b> {message}<br>\n")
                f.write(f"<b>Archivo:</b> {file_path}, <b>Línea:</b> {start_line}<br>\n")
                f.write("</p>\n")
        else:
            f.write("<p>No se encontraron problemas.</p>\n")

        f.write("</body></html>\n")

# Usar el script
sarif_to_html('semgrep-report.sarif', 'semgrep-report.html')
