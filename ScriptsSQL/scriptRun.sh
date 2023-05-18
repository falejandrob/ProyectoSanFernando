#!/bin/bash

set -e  # Salir inmediatamente si algún comando falla

# Función para mostrar mensajes informativos
show_message() {
    echo ">> $1"
}

# Función para mostrar mensajes de error y salir
show_error() {
    echo "Error: $1"
    exit 1
}

# Verificar la presencia de los comandos necesarios
check_dependencies() {
    local missing_deps=()
    local dependencies=("git" "cp" "npm" "composer" "php")

    for dep in "${dependencies[@]}"; do
        if ! command -v "$dep" >/dev/null 2>&1; then
            missing_deps+=("$dep")
        fi
    done

    if [ ${#missing_deps[@]} -gt 0 ]; then
        show_error "Los siguientes comandos no están instalados: ${missing_deps[*]}. Por favor, instala los comandos antes de continuar."
    fi
}

# Ejecutar comando y manejar errores
run_command() {
    local command="$1"
    local error_message="$2"

    show_message "Ejecutando: $command"
    if ! eval "$command"; then
        show_error "$error_message"
    fi
}

# Eliminar el directorio existente
show_message "Eliminando el directorio existente..."
run_command "rm -rf ProyectoSanFernando/" "No se pudo eliminar el directorio existente."

# Clonar el repositorio
show_message "Clonando el repositorio..."
run_command "git clone https://github.com/PriceSt1/ProyectoSanFernando.git" "No se pudo clonar el repositorio."

# Copiar los archivos al directorio 'app'
show_message "Copiando archivos al directorio 'app'..."
run_command "cp -r ProyectoSanFernando/* app/" "No se pudieron copiar los archivos al directorio 'app'."

# Navegar al directorio 'app'
show_message "Ingresando al directorio 'app'..."
run_command "cd app/" "No se pudo ingresar al directorio 'app'."

# Verificar las dependencias
show_message "Verificando dependencias..."
check_dependencies

# Instalar dependencias de npm
show_message "Instalando dependencias de npm..."
run_command "npm install" "No se pudieron instalar las dependencias de npm."

# Instalar dependencias de Composer
show_message "Instalando dependencias de Composer..."
run_command "composer install" "No se pudieron instalar las dependencias de Composer."

# Compilar
show_message "Compilando..."
run_command "npm run build" "No se pudo compilar."

# Limpiar la cache de optimización
show_message "Limpiando la cache de optimización..."
run_command "php artisan optimize:clear" "No se pudo limpiar la cache de optimización."

# Establecer permisos
show_message "Estableciendo permisos..."
run_command "chmod -R 777 *" "No se pudieron establecer los permisos."

# Ejecutar migraciones con seed
show_message "Ejecutando migraciones con seed..."
run_command "php artisan migrate:fresh --seed" "No se pudieron ejecutar las migraciones con seed."

# Finalización exitosa
show_message "¡El script se ha ejecutado correctamente!"
exit 0
