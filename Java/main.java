import java.util.*;

class Node {
    String data;
    Node left, right;

    public Node(String data) {
        this.data = data;
        left = right = null;
    }
}

public class Main {

    public static boolean isOperator(String ch) {
        return (ch.equals("+") || ch.equals("-") || ch.equals("*") || ch.equals("/") || ch.equals("^"));
    }

    public static Node expressionTree(String[] equation, int notation) {
        Stack<Node> st = new Stack<>();
        try {
            if (notation == 1) { // Prefix
                for (int i = equation.length - 1; i >= 0; i--) {
                    processOperator(equation[i], st, notation);
                }
            } else if (notation == 2) { // Infix
                st = infixToTree(equation);
            } else if (notation == 3) { // Postfix
                for (String s : equation) {
                    processOperator(s, st, notation);
                }
            } else {
                return null;
            }
        } catch (Exception e) {
            System.out.println("\nAn error occurred: " + e.getMessage());
            e.printStackTrace();
        }
        return st.pop();
    }

    public static void processOperator(String equation, Stack<Node> st, int notation) {
        if (!isOperator(equation)) {
            st.push(new Node(equation));
        } else {
            Node temp = new Node(equation);
            Node t1 = st.pop();
            Node t2 = st.pop();
            
            if (notation == 1) { // Prefix
                temp.left = t1;
                temp.right = t2;
            } else { // Postfix
                temp.left = t2;
                temp.right = t1;
            }
            st.push(temp);
        }
    }

    public static Stack<Node> infixToTree(String[] equation) {
        Stack<Node> operands = new Stack<>();
        Stack<String> operators = new Stack<>();

        for (String token : equation) {
            if (token.equals("(")) {
                operators.push(token);
            } else if (token.equals(")")) {
                while (!operators.isEmpty() && !operators.peek().equals("(")) {
                    processInfixOperator(operands, operators.pop());
                }
                operators.pop(); // Remove '('
            } else if (isOperator(token)) {
                while (!operators.isEmpty() && precedence(operators.peek()) >= precedence(token)) {
                    processInfixOperator(operands, operators.pop());
                }
                operators.push(token);
            } else {
                operands.push(new Node(token));
            }
        }
        
        while (!operators.isEmpty()) {
            processInfixOperator(operands, operators.pop());
        }
        return operands;
    }

    public static void processInfixOperator(Stack<Node> operands, String operator) {
        Node right = operands.pop();
        Node left = operands.pop();
        Node temp = new Node(operator);
        temp.left = left;
        temp.right = right;
        operands.push(temp);
    }

    public static int precedence(String op) {
        if (op.equals("+") || op.equals("-")) return 1;
        if (op.equals("*") || op.equals("/")) return 2;
        if (op.equals("^")) return 3;
        return -1;
    }

    public static void display(Node root) {
        if (root != null) {
            display(root.left);
            System.out.print(root.data + " ");
            display(root.right);
        }
    }

    public static int calculateTree(Node tree) {
        if (tree == null) return 0;
        if (tree.left == null && tree.right == null) return Integer.parseInt(tree.data);
        int left = calculateTree(tree.left);
        int right = calculateTree(tree.right);
        switch (tree.data) {
            case "+": return left + right;
            case "-": return left - right;
            case "*": return left * right;
            case "/": return left / right;
            default: return 0;
        }
    }

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        String[] choice = {"Prefix", "Infix", "Postfix"};
        
        while (true) {
            System.out.println("Tree Calculate Expression");
            for (int i = 0; i < choice.length; i++) {
                System.out.printf("%d.%s\n", i + 1, choice[i]);
            }
            System.out.println("4.Exit program");
            
            System.out.print("Your choice number is: ");
            int select = sc.nextInt();
            sc.nextLine();
            
            if (select > 0 && select <= 3) {
                System.out.printf("Your %s: ", choice[select - 1]);
                String input = sc.nextLine();
                String[] equation = input.split(" ");
                
                Node root = expressionTree(equation, select);
                System.out.print("Display at inorder: ");
                display(root);
                System.out.println("\nSum of equation: " + calculateTree(root));
                System.out.println("-----------------------------");
            } else if (select == 4) {
                System.out.println("Exiting...");
                break;
            } else {
                System.out.println("Invalid choice");
            }
        }
        sc.close();
    }
}
