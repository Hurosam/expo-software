<?php
// ========================================
// DESPUÉS: Aplicando el principio I de SOLID
// ========================================

// Interfaces pequeñas y específicas - cada una con un propósito claro
interface OperacionesBasicas {
    public function sumar($a, $b);
    public function restar($a, $b);
    public function multiplicar($a, $b);
    public function dividir($a, $b);
}

interface OperacionesAvanzadas {
    public function calcularPorcentaje($a, $b);
    public function calcularRaizCuadrada($a);
    public function calcularPotencia($a, $b);
}

interface OperacionesCientificas {
    public function calcularLogaritmo($a);
    public function calcularSeno($a);
    public function calcularCoseno($a);
}

// Calculadora básica: SOLO implementa lo que necesita
class CalculadoraBasica implements OperacionesBasicas {
    public function sumar($a, $b) {
        return $a + $b;
    }
    
    public function restar($a, $b) {
        return $a - $b;
    }
    
    public function multiplicar($a, $b) {
        return $a * $b;
    }
    
    public function dividir($a, $b) {
        return $b != 0 ? $a / $b : "Error: División por cero";
    }
}

// Calculadora avanzada: implementa básicas Y avanzadas
class CalculadoraAvanzada implements OperacionesBasicas, OperacionesAvanzadas {
    public function sumar($a, $b) {
        return $a + $b;
    }
    
    public function restar($a, $b) {
        return $a - $b;
    }
    
    public function multiplicar($a, $b) {
        return $a * $b;
    }
    
    public function dividir($a, $b) {
        return $b != 0 ? $a / $b : "Error: División por cero";
    }
    
    public function calcularPorcentaje($a, $b) {
        return ($a * $b) / 100;
    }
    
    public function calcularRaizCuadrada($a) {
        return $a >= 0 ? sqrt($a) : "Error: Número negativo";
    }
    
    public function calcularPotencia($a, $b) {
        return pow($a, $b);
    }
}

// Calculadora científica: implementa todas las interfaces
class CalculadoraCientifica implements OperacionesBasicas, OperacionesAvanzadas, OperacionesCientificas {
    public function sumar($a, $b) {
        return $a + $b;
    }
    
    public function restar($a, $b) {
        return $a - $b;
    }
    
    public function multiplicar($a, $b) {
        return $a * $b;
    }
    
    public function dividir($a, $b) {
        return $b != 0 ? $a / $b : "Error: División por cero";
    }
    
    public function calcularPorcentaje($a, $b) {
        return ($a * $b) / 100;
    }
    
    public function calcularRaizCuadrada($a) {
        return $a >= 0 ? sqrt($a) : "Error: Número negativo";
    }
    
    public function calcularPotencia($a, $b) {
        return pow($a, $b);
    }
    
    public function calcularLogaritmo($a) {
        return $a > 0 ? log($a) : "Error: Logaritmo de número no positivo";
    }
    
    public function calcularSeno($a) {
        return sin(deg2rad($a));
    }
    
    public function calcularCoseno($a) {
        return cos(deg2rad($a));
    }
}

// Procesamiento del formulario
$resultado = "";
$error = "";
$tipoCalculadora = $_POST['tipo_calculadora'] ?? 'basica';

if ($_POST) {
    $num1 = floatval($_POST['num1'] ?? 0);
    $num2 = floatval($_POST['num2'] ?? 0);
    $operacion = $_POST['operacion'] ?? '';
    
    // Seleccionar el tipo de calculadora según la necesidad
    switch($tipoCalculadora) {
        case 'basica':
            $calc = new CalculadoraBasica();
            break;
        case 'avanzada':
            $calc = new CalculadoraAvanzada();
            break;
        case 'cientifica':
            $calc = new CalculadoraCientifica();
            break;
        default:
            $calc = new CalculadoraBasica();
    }
    
    try {
        switch($operacion) {
            case 'sumar':
                $resultado = $calc->sumar($num1, $num2);
                break;
            case 'restar':
                $resultado = $calc->restar($num1, $num2);
                break;
            case 'multiplicar':
                $resultado = $calc->multiplicar($num1, $num2);
                break;
            case 'dividir':
                $resultado = $calc->dividir($num1, $num2);
                break;
            case 'porcentaje':
                if ($calc instanceof OperacionesAvanzadas) {
                    $resultado = $calc->calcularPorcentaje($num1, $num2);
                } else {
                    $error = "Operación no disponible en calculadora básica";
                }
                break;
            case 'raiz':
                if ($calc instanceof OperacionesAvanzadas) {
                    $resultado = $calc->calcularRaizCuadrada($num1);
                } else {
                    $error = "Operación no disponible en calculadora básica";
                }
                break;
            case 'potencia':
                if ($calc instanceof OperacionesAvanzadas) {
                    $resultado = $calc->calcularPotencia($num1, $num2);
                } else {
                    $error = "Operación no disponible en calculadora básica";
                }
                break;
            case 'logaritmo':
                if ($calc instanceof OperacionesCientificas) {
                    $resultado = $calc->calcularLogaritmo($num1);
                } else {
                    $error = "Operación no disponible en este tipo de calculadora";
                }
                break;
            case 'seno':
                if ($calc instanceof OperacionesCientificas) {
                    $resultado = $calc->calcularSeno($num1);
                } else {
                    $error = "Operación no disponible en este tipo de calculadora";
                }
                break;
            case 'coseno':
                if ($calc instanceof OperacionesCientificas) {
                    $resultado = $calc->calcularCoseno($num1);
                } else {
                    $error = "Operación no disponible en este tipo de calculadora";
                }
                break;
            default:
                $error = "Operación no válida";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ DESPUÉS - Calculadora (Principio I Aplicado)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f0f8f0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,128,0,0.1);
            border: 2px solid #c8e6c9;
        }
        h1 {
            color: #2e7d32;
            text-align: center;
            margin-bottom: 30px;
        }
        .success {
            background-color: #e8f5e9;
            border: 2px solid #4caf50;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #2e7d32;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input:focus, select:focus {
            border-color: #4caf50;
            outline: none;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e9;
            border: 2px solid #4caf50;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
            color: #2e7d32;
            font-weight: bold;
        }
        .error {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff3e0;
            border: 2px solid #ff9800;
            border-radius: 5px;
            color: #e65100;
            text-align: center;
            font-weight: bold;
        }
        .benefits {
            margin-top: 30px;
            padding: 20px;
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            border-radius: 0 5px 5px 0;
        }
        .benefits h3 {
            color: #2e7d32;
            margin-top: 0;
        }
        .code-good {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: monospace;
            font-size: 14px;
            border-left: 4px solid #4caf50;
        }
        .calculator-info {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .calc-type {
            flex: 1;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
        }
        .calc-basica { background-color: #e3f2fd; border: 2px solid #2196f3; }
        .calc-avanzada { background-color: #f3e5f5; border: 2px solid #9c27b0; }
        .calc-cientifica { background-color: #fff3e0; border: 2px solid #ff9800; }
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ DESPUÉS - Calculadora PHP</h1>
        <p style="text-align: center; color: #2e7d32; margin-bottom: 30px; font-weight: bold;">
            Aplicando correctamente el Principio I de SOLID
        </p>
        
        <div class="success">
            <strong>✅ SOLUCIÓN:</strong> Ahora tenemos interfaces pequeñas y específicas. 
            Cada calculadora implementa solo lo que necesita, sin métodos innecesarios.
        </div>
        
        <div class="calculator-info">
            <div class="calc-type calc-basica">
                <strong>🔵 Básica</strong><br>
                4 operaciones<br>
                (+ - × ÷)
            </div>
            <div class="calc-type calc-avanzada">
                <strong>🟣 Avanzada</strong><br>
                Básica + 3 más<br>
                (% √ ^)
            </div>
            <div class="calc-type calc-cientifica">
                <strong>🟠 Científica</strong><br>
                Todas las operaciones<br>
                (log, sen, cos)
            </div>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="tipo_calculadora">Tipo de Calculadora:</label>
                <select id="tipo_calculadora" name="tipo_calculadora" required onchange="actualizarOperaciones()">>
                    <option value="basica" <?= $tipoCalculadora == 'basica' ? 'selected' : '' ?>>
                        🔵 Calculadora Básica (4 operaciones)
                    </option>
                    <option value="avanzada" <?= $tipoCalculadora == 'avanzada' ? 'selected' : '' ?>>
                        🟣 Calculadora Avanzada (7 operaciones)
                    </option>
                    <option value="cientifica" <?= $tipoCalculadora == 'cientifica' ? 'selected' : '' ?>>
                        🟠 Calculadora Científica (10 operaciones)
                    </option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="num1">Primer número:</label>
                <input type="number" step="any" id="num1" name="num1" 
                       value="<?= htmlspecialchars($_POST['num1'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="num2">Segundo número:</label>
                <input type="number" step="any" id="num2" name="num2" 
                       value="<?= htmlspecialchars($_POST['num2'] ?? '') ?>">
                <small style="color: #666; font-size: 12px;">
                    *Opcional para raíz, logaritmo, seno y coseno
                </small>
            </div>
            
            <div class="form-group">
                <label for="operacion">Operación:</label>
                <select id="operacion" name="operacion" required>
                    <option value="">Selecciona una operación</option>
                    <optgroup label="✅ Operaciones Básicas" id="basicas">
                        <option value="sumar" <?= ($_POST['operacion'] ?? '') == 'sumar' ? 'selected' : '' ?>>
                            ➕ Sumar
                        </option>
                        <option value="restar" <?= ($_POST['operacion'] ?? '') == 'restar' ? 'selected' : '' ?>>
                            ➖ Restar
                        </option>
                        <option value="multiplicar" <?= ($_POST['operacion'] ?? '') == 'multiplicar' ? 'selected' : '' ?>>
                            ✖️ Multiplicar
                        </option>
                        <option value="dividir" <?= ($_POST['operacion'] ?? '') == 'dividir' ? 'selected' : '' ?>>
                            ➗ Dividir
                        </option>
                    </optgroup>
                    <optgroup label="🟣 Operaciones Avanzadas" id="avanzadas" style="display: none;">
                        <option value="potencia" <?= ($_POST['operacion'] ?? '') == 'potencia' ? 'selected' : '' ?>>
                            🔢 Potencia (a^b)
                        </option>
                        <option value="raiz" <?= ($_POST['operacion'] ?? '') == 'raiz' ? 'selected' : '' ?>>
                            √ Raíz cuadrada
                        </option>
                        <option value="porcentaje" <?= ($_POST['operacion'] ?? '') == 'porcentaje' ? 'selected' : '' ?>>
                            % Porcentaje (b% de a)
                        </option>
                    </optgroup>
                    <optgroup label="🟠 Operaciones Científicas" id="cientificas" style="display: none;">
                        <option value="logaritmo" <?= ($_POST['operacion'] ?? '') == 'logaritmo' ? 'selected' : '' ?>>
                            📊 Logaritmo natural
                        </option>
                        <option value="seno" <?= ($_POST['operacion'] ?? '') == 'seno' ? 'selected' : '' ?>>
                            📐 Seno (grados)
                        </option>
                        <option value="coseno" <?= ($_POST['operacion'] ?? '') == 'coseno' ? 'selected' : '' ?>>
                            📐 Coseno (grados)
                        </option>
                    </optgroup>
                </select>
            </div>
            
            <button type="submit">🧮 Calcular</button>
        </form>
        
        <?php if ($resultado !== ""): ?>
            <div class="result">
                ✅ Resultado: <?= htmlspecialchars($resultado) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="error">
                ⚠️ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <div class="benefits">
            <h3>🎯 Beneficios del Principio I aplicado:</h3>
            
            <div class="code-good">
// Interfaces pequeñas y específicas<br>
interface OperacionesBasicas { /* solo 4 métodos */ }<br>
interface OperacionesAvanzadas { /* solo 3 métodos */ }<br>
interface OperacionesCientificas { /* solo 3 métodos */ }<br><br>
// Cada clase implementa SOLO lo que necesita<br>
class CalculadoraBasica implements OperacionesBasicas { ... }<br>
class CalculadoraAvanzada implements OperacionesBasicas, OperacionesAvanzadas { ... }
            </div>
            
            <ul>
                <li>✅ <strong>Principio I respetado:</strong> Cada clase implementa solo lo que realmente necesita</li>
                <li>✅ <strong>Sin métodos inútiles:</strong> No hay implementaciones que solo lanzan errores</li>
                <li>✅ <strong>Flexibilidad:</strong> Fácil agregar nuevos tipos de calculadoras</li>
                <li>✅ <strong>Mantenibilidad:</strong> Cambios en una interfaz no afectan a las demás</li>
                <li>✅ <strong>Claridad:</strong> Cada interfaz tiene un propósito específico y claro</li>
                <li>✅ <strong>Escalabilidad:</strong> Puedes combinar interfaces según necesidades</li>
            </ul>
            
            <p style="margin-top: 20px; font-weight: bold; color: #2e7d32;">
                💡 <strong>Resultado:</strong> Código más limpio, mantenible y flexible que sigue correctamente el Principio I de SOLID
            </p>
        </div>
    </div>
    
    <script>
        function actualizarOperaciones() {
            const tipoCalc = document.getElementById('tipo_calculadora').value;
            const avanzadas = document.getElementById('avanzadas');
            const cientificas = document.getElementById('cientificas');
            
            // Resetear selección
            document.getElementById('operacion').value = '';
            
            // Mostrar/ocultar grupos de operaciones según el tipo
            switch(tipoCalc) {
                case 'basica':
                    avanzadas.style.display = 'none';
                    cientificas.style.display = 'none';
                    break;
                case 'avanzada':
                    avanzadas.style.display = 'block';
                    cientificas.style.display = 'none';
                    break;
                case 'cientifica':
                    avanzadas.style.display = 'block';
                    cientificas.style.display = 'block';
                    break;
            }
        }
        
        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            actualizarOperaciones();
        });
    </script>
</body>
</html>