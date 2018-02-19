import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintStream;
import java.util.Scanner;

public class Parser {
    public static void main(String[] args) throws FileNotFoundException {
        Scanner input = new Scanner(new File("quotes9u.txt"));
        PrintStream output = new PrintStream(new File("quotes9.txt"));
        int counter = 0;
        while (input.hasNextLine()) {
            String line = input.nextLine().trim();
            System.out.println(line);
            System.out.println(counter++);
            if (line.length() != 0) {
                if (line.charAt(0) != '*') {
                    output.print(line + " ");
                } else {
                    //output.println();
                }
            } else {
                output.println();
            }
        }
    }
}
