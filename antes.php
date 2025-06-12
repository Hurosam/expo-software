<?php
// ========================================
// ANTES: Violando el principio I de SOLID
// ========================================

// Una interfaz "gorda" que obliga a implementar métodos que no todos necesitan
interface CalculadoraCompleta {
    public function sumar($a, $b);
    public function restar($a, $b);
    public function multiplicar($a, $b);
    public function dividir($a, $b);
    public function calcularPorcentaje($a, $b);
    public function calcularRaizCuadrada($a);
    public function calcularPotencia($a, $b);
    public function calcularLogaritmo($a);
}

// Esta clase se ve obligada a implementar métodos que quizás no necesita
class CalculadoraBasica implements CalculadoraCompleta {
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
    
    // ¡Métodos que no necesitamos pero estamos OBLIGADOS a implementar!
    public function calcularPorcentaje($a, $b) {
        throw new Exception("Operación no soportada en calculadora básica");
    }
    
    public function calcularRaizCuadrada($a) {
        throw new Exception("Operación no soportada en calculadora básica");
    }
    
    public function calcularPotencia($a, $b) {
        throw new Exception("Operación no soportada en calculadora básica");
    }
    
    public function calcularLogaritmo($a) {
        throw new Exception("Operación no soportada en calculadora básica");
    }
}

// Procesamiento del formulario
$resultado = "";
$error = "";

if ($_POST) {
    $num1 = floatval($_POST['num1'] ?? 0);
    $num2 = floatval($_POST['num2'] ?? 0);
    $operacion = $_POST['operacion'] ?? '';
    
    $calc = new CalculadoraBasica();
    
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
                $resultado = $calc->calcularPorcentaje($num1, $num2);
                break;
            case 'raiz':
                $resultado = $calc->calcularRaizCuadrada($num1);
                break;
            case 'potencia':
                $resultado = $calc->calcularPotencia($num1, $num2);
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
    <title>❌ ANTES - Calculadora (Violando Principio I)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(255,0,0,0.1);
            border: 2px solid #ffcdd2;
        }
        h1 {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 30px;
        }
        .warning {
            background-color: #ffebee;
            border: 2px solid #f44336;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #c62828;
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
            border-color: #f44336;
            outline: none;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #d32f2f;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e8;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
        }
        .error {
            margin-top: 20px;
            padding: 15px;
            background-color: #ffebee;
            border: 2px solid #f44336;
            border-radius: 5px;
            color: #c62828;
            text-align: center;
            font-weight: bold;
        }
        .problem {
            margin-top: 30px;
            padding: 20px;
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            border-radius: 0 5px 5px 0;
        }
        .problem h3 {
            color: #d32f2f;
            margin-top: 0;
        }
        .code-bad {
            background-color: #ffebee;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: monospace;
            font-size: 14px;
            border-left: 4px solid #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>❌ ANTES - Calculadora PHP</h1>
        <p style="text-align: center; color: #d32f2f; margin-bottom: 30px; font-weight: bold;">
            Violando el Principio I de SOLID
        </p>
        
        <div class="warning">
            <strong>⚠️ PROBLEMA:</strong> Esta calculadora básica está obligada a implementar 
            métodos avanzados que no necesita, violando el principio de segregación de interfaces.
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="num1">Primer número:</label>
                <input type="number" step="any" id="num1" name="num1" 
                       value="<?= htmlspecialchars($_POST['num1'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="num2">Segundo número:</label>
                <input type="number" step="any" id="num2" name="num2" 
                       value="<?= htmlspecialchars($_POST['num2'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="operacion">Operación:</label>
                <select id="operacion" name="operacion" required>
                    <option value="">Selecciona una operación</option>
                    <optgroup label="✅ Operaciones Básicas (Funcionan)">
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
                    <optgroup label="❌ Operaciones Avanzadas (Fallan)">
                        <option value="potencia" <?= ($_POST['operacion'] ?? '') == 'potencia' ? 'selected' : '' ?>>
                            🔢 Potencia (ERROR)
                        </option>
                        <option value="raiz" <?= ($_POST['operacion'] ?? '') == 'raiz' ? 'selected' : '' ?>>
                            √ Raíz cuadrada (ERROR)
                        </option>
                        <option value="porcentaje" <?= ($_POST['operacion'] ?? '') == 'porcentaje' ? 'selected' : '' ?>>
                            % Porcentaje (ERROR)
                        </option>
                    </optgroup>
                </select>
            </div>
            
            <button type="submit">🧮 Calcular</button>
        </form>
        
        <?php if ($resultado !== ""): ?>
            <div class="result">
                <strong>Resultado: <?= htmlspecialchars($resultado) ?></strong>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="error">
                <strong>❌ <?= htmlspecialchars($error) ?></strong>
            </div>
        <?php endif; ?>
        
        <div class="problem">
            <h3>🚨 Problemas de este diseño:</h3>
            
            <div class="code-bad">
// Interfaz "gorda" que obliga a implementar TODO<br>
interface CalculadoraCompleta {<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function sumar($a, $b);<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function restar($a, $b);<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function multiplicar($a, $b);<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function dividir($a, $b);<br>
&nbsp;&nbsp;&nbsp;&nbsp;// ¡Métodos que no necesitamos!<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function calcularPorcentaje($a, $b);<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function calcularRaizCuadrada($a);<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function calcularPotencia($a, $b);<br>
&nbsp;&nbsp;&nbsp;&nbsp;public function calcularLogaritmo($a);<br>
}
            </div>
            
            <ul>
                <li>❌ <strong>Violación del principio I:</strong> La calculadora básica debe implementar métodos que no necesita</li>
                <li>❌ <strong>Métodos inútiles:</strong> Muchos métodos solo lanzan excepciones</li>
                <li>❌ <strong>Acoplamiento fuerte:</strong> Cambios en la interfaz afectan a todas las clases</li>
                <li>❌ <strong>Código innecesario:</strong> Implementaciones vacías o con errores</li>
                <li>❌ <strong>Confuso para desarrolladores:</strong> No está claro qué métodos realmente funcionan</li>
            </ul>
            
            <p style="margin-top: 20px; font-weight: bold; color: #d32f2f;">
                💡 <strong>Solución:</strong> Dividir la interfaz en interfaces más pequeñas y específicas
            </p>
        </div>
    </div>
</body>
</html>