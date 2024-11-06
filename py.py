import os

def check_line_endings(directory):
    for root, _, files in os.walk(directory):
        for file in files:
            file_path = os.path.join(root, file)
            with open(file_path, 'rb') as f:
                content = f.read()
                if b'\r\n' not in content and b'\n' in content:
                    # print(f"Arquivo com quebras de linha do Linux: {file_path}")
                    x = 1
                else:
                    print(f"Arquivo com quebras de linha do Windows: {file_path}")

# Substitua pelo caminho do seu diretório
directory_path = "."
check_line_endings(directory_path)
